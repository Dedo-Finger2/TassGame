@extends('layouts.app')
@section('title', 'Edit xxx')

@section('content')
    <form action="" method="POST">
        @csrf

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <input type="submit" value="Login" name="login" id="login">
    </form>
@endsection
