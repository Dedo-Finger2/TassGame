@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>
    <span>Welcome {{ $user->name }}!</span>
    <a href="{{ route('tasks.my-tasks') }}">My Tasks</a> - <a href="{{ route('tasks.my-completed-tasks') }}">My Completed
        Tasks</a> - <a href="{{ route('dashboard') }}">My Dashboard</a> - <a href="{{ route('inventory') }}">My Iventory</a>
    <hr>

    <h2>Status:</h2>
    <ul>
        <li>Level: {{ $user->level }}🌳</li>
        <li>Coins: {{ $user->coins }}/{{ $user->coin_limit }}🪙</li>
        <li>Exp: {{ $user->exp }}/{{ $user->exp_next_level }}✨</li>
        <li>Joined at: {{ $user->created_at }}🗓️</li>
    </ul>
    <hr>
@endsection
