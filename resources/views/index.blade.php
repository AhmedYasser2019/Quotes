
@extends('layouts.master')
@section('title')
    Trending quotes
    @endsection
@section('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: Georgia, "Times New Roman",serif;
            font-size: 16px;
            line-height: 20px;
        }


        .main {
            width: 50%;
            margin: 45px auto;

        }


        .edit_quote {
            text-align: center;
        }
        .quotes {
            text-align: center;
        }
        .quote {
            position: relative;
            display: inline-block;
            border: 1px solid #ccc;
            width: 20%;
            box-shadow: 2px 2px 2px #cccccc;
            margin: 32px;
            padding: 16px;
            vertical-align: top;
            background-color: #fff6e0;
        }
        .quote .first-in-line {
            margin-left: 0;

        }
        .quote .last-in-line {
            margin-right: 0;
        }
        .quote .info {
            margin-top: 8px;
            font-size: 12px;
            font-family: "Robto" , sans-serif;
            color: #ccc;
        }
        .quote.info a {
            color: #ccc;
        }
        .quote.info a:hover,
        .quote.info a:active {
            color: #aaaaaa;
        }
        .quote .delete {
            position: absolute;
            top: 0;
            right: 4px;
            font-family: sans-serif;
        }
        .quote .delete a {
            color: #bbb;
            text-decoration: none;

        }
        .quote .delete a:hover,
        .quote .delete a:active {
            color: red;
        }
        .input_group {
            margin: 16px 0;
        }
        .input_group label {
            display: block;
            text-align: center;
            font-weight: bold;
        }
        .input_group input,
        .input_group textarea {
            border: 1px solid #cccccc;
            border-radius: 3px;
            font-family: inherit;
            font-size: inherit;
            padding: 4px 8px;
        }
        .input_group #author {
            width: 200px;
        }
        .input_group textarea {
            width: 400px;
        }
        .btn {
            border: 1px solid #cccccc;
            border-radius: 3px;
            background-color: #fff6e0;
            font-size: inherit;
            font-family: Roboto , sans-serif;
            padding: 8px;
            cursor: pointer;
        }
        .btn:hover,
        .btn:active {
            background-color: #fff6e0;
        }
        .info-box {
            text-align: center;
            margin: auto;
            padding: 16px;
            border-radius: 3px;
            width: 350px;
        }
        .info-box .fail {
            border: 1px solid #ff6b6a;
            background-color: #ffczba;
            color: #ff6b6a;

        }
        .info-box .success {
            border: 1px solid #46cc71;
            background-color: #bdffb6;
            color: #46cc71;
        }
        .filter-bar {
            width: 100%;
            padding: 16px;
            background-color: #f9ffc3;
            color: black;
            text-align: center;
        }
        .pagination {
            font-size: 20px;
        }
        .pagination a {
            color: black;
            text-decoration: none;
        }
        .pagination a:hover,
        .pagination a:active {
            color: #cccccc;

        }



    </style>
@endsection
@section('content')

    @if(!empty(Request::segment(1)))
        <section class="filter-bar">
            A filter has been set ! <a href="{{route('index')}}">show all quotes</a>
        </section>
    @endif

    @if (count($errors) > 0)
        <div >
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('success'))
        <section class="info-box success">done</section>
    @endif

    <section class="quotes">
        <h1>Latest Quotes</h1>
        @for($i =0;$i < count($quotes);$i++)
            <article class="quote">
                <div class="delete"><a href="{{route('delete',['quote_id' => $quotes[$i]->id ])}}">x</a></div>
                {{$quotes[$i]->quote}}
                <div class="info">
                    Created By <a href="{{route('index',['author' => $quotes[$i]->author->name ])}}">{{$quotes[$i]->author->name}}</a> on {{$quotes[$i]->created_at}}</div>
            </article>
        @endfor
        <div class="pagination">
            @if($quotes->currentPage() !== 1)
                <a href="{{$quotes->previousPageUrl()}}"><span class="fa fa-caret-left"></span> </a>
                @endif
            @if($quotes->currentPage() !== $quotes->lastPage() && $quotes->hasPages())
                <a href="{{$quotes->nextPageUrl() }}"><span class="fa fa-caret-right"></span> </a>
                @endif
        </div>
    </section>
    <section class="edit_quote" >
        <h1>Add a Quote </h1>
        <form method="POST" action="{{route('create')}}">
            <div class="input_group">
                <label for="author"> Your Name </label>
                <input type="text" name="author" id="author" placeholder="Your Name"/>
            </div>
            <div class="input_group">
                <label for="email"> Your E-Mail </label>
                <input type="text" name="email" id="email" placeholder="Your E-Mail"/>
            </div>
            <div class="input_group">
                <label for="quote"> Your Quote </label>
                <textarea id="quote" name="quote" rows="5" placeholder="Quote"></textarea>
            </div>
            <button type="submit" class="btn">Submit Quote</button>
            <input type="hidden" name="_token" value="{{session()->token()}}"/>
        </form>
    </section>
    @endsection