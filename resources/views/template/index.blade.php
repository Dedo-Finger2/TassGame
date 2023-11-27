@extends('layouts.app')
@section('title', 'List of xxx')

@section('content')
    <h1>xxx</h1>
    <a href="">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count(xxxs) > 0)
        @foreach (xxxs as xxx)
            <div>
                <h2>{{ xxx }}</h2>
                <ul>
                    <li>{{ }}</li>
                </ul>
                <p>{{ }}</p>
                <a href="">View</a> - <a href="">Edit</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No xxxs found!</span>
    @endif
@endsection
