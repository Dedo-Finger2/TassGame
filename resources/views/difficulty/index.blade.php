@extends('layouts.app')
@section('title', 'List of difficulties')

@section('content')
    <h1>Difficulties</h1>
    <a href="{{ route('difficulties.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($difficulties) > 0)
        @foreach ($difficulties as $difficulty)
            <div>
                <h2>{{ $difficulty->name }}</h2>
                <ul>
                    <li>{{ $difficulty->exp }}✨</li>
                    <li>{{ $difficulty->coins }}🪙</li>
                </ul>
                <p>{{ $difficulty->description }}</p>
                <a href="{{ route('difficulties.show', ['difficulty' => $difficulty]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Difficulty found!</span>
    @endif
@endsection
