<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class AdminController extends Controller
{
    public function getLogin () {
        return view('admin.login');

    }
    public function getLogout () {
        Auth::logout();
        return redirect()->back();

    }
    public function getDashboard () {

        $authors = Author::all();
        return view('admin.dashboard',['authors' => $authors]);

    }

    public function postLogin(Request $request) {

        $this->validate($request,[
            'name' => 'required',
            'password' => 'required'
        ]);
        if (!Auth::attempt(['name' => $request['name'] , 'password' => $request['password']]))
        {
            return redirect()->back()->with('fail','could not login!');
        }
        return redirect()->route('admin.dashboard');

    }
}
