@extends('layouts.app')

@section('content')
    <h1>Welcome</h1><span>Name: {{ auth()->user()->name }}</span>

    <a href="{{ route('logout') }}">Logout</a>

    @if (session('success'))
        <span>{{ session('success') }}</span>
    @endif
@endsection
