@extends('layouts.app')
@section('title', 'Login')

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

    @if (session('error'))
        <div>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('auth') }}" method="POST">
        @csrf

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <input type="submit" value="Login" name="login" id="login">
        <a href="{{ route('register') }}">Dont have account yet?</a>
    </form>
@endsection
