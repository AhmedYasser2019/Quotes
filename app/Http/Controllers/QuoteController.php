<?php

namespace App\Http\Controllers;
use App\Author;
use App\AuthorLog;
use App\Events\Event;
use App\Events\QuoteCreated;
use App\Quote;
use Validator;

use Illuminate\Http\Request;


use App\Http\Requests;

class QuoteController extends Controller
{
    public function getIndex ($author = null){
        if (!is_null($author))
        {
            $quote_author = Author::where('name',$author)->first();
            if ($quote_author)
            {


             $quotes = $quote_author->quotes->paginate(6);
            }
        }else {

                $quotes = Quote::paginate(6);
            }

//        return count($quotes);
        return view('index',['quotes' => $quotes]);

    }
    public function postQuote (Request $request) {
        $this->validate($request,[
           'author' => 'required|max:60|alpha',
            'quote' => 'required|max:500',
            'email' => 'required|email'
        ]);
        $authorText = ucfirst($request['author']);
        $quoteText = $request['quote'];

        $author = Author::where('name',$authorText)->first();
        if (!$author) {
            $author = new Author();
            $author->name = $authorText;
            $author->email = $request['email'];
            $author->save();
        }
        $quote = new Quote();
        $quote->quote = $quoteText;
        $author->quotes()->save($quote);
        event(new QuoteCreated($author));
        return redirect()->route('index')->with([
            'success' => 'Quote saved!'
        ]);
    }
    public function getDeleteQuote ($quote_id){
       $quote = Quote::find($quote_id);
        //$quote = Quote::where('id',$quote_id)->first();
//        return count($quote->author->quotes);
        $author_delete = false;
        if (count($quote->author->quotes)=== 1)
        {
            $quote->author->delete();
            $author_delete = true;
        }
        $quote->delete();
        $msg = $author_delete?'Quote and Author are deleted!':'Quote is deleted!';
        return redirect()->route('index')->with(['success' => $msg]);
    }
    public function getMailCallback ($author_name) {

        $author_log = new AuthorLog();
        $author_log->author = $author_name;
        $author_log->save();

        return view('email.callback',['author' => $author_name]);
    }
}
