@extends('layouts.app')
@section('title', 'Register')

@section('content')

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="name" name="name" id="name">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <input type="submit" value="Register" name="login" id="login">
        <a href="{{ route('login') }}">I have an account</a>
    </form>
@endsection
