@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>
    <span>Welcome {{ $user->name }}!</span>
    <hr>

    <h2>Status:</h2>
    <ul>
        <li>Level: {{ $user->level }}🌳</li>
        <li>Coins: {{ $user->coins }}🪙</li>
        <li>Exp: {{ $user->exp }}/{{ $user->exp_next_level }}✨</li>
        <li>Joined at: {{ $user->created_at }}🗓️</li>
    </ul>
    <hr>
@endsection
