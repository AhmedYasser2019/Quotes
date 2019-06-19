@extends('layouts.master')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('fail'))
        <div >
            {{Session::get('fail')}}
        </div>
    @endif
<form action="{{route('admin.login')}}" method="post">
    <div class="input_group">
        <label for="name"> Your Name </label>
        <input type="text" name="name" id="name" placeholder="Your Name"/>
    </div>
    <div class="input_group">
        <label for="password"> Your Password </label>
        <input type="password" name="password" id="password" placeholder="Your Password"/>
    </div>
    <button type="submit">Submit</button>
    <input type="hidden" name="_token" value="{{Session::token()}}"/>
</form>
    @endsection