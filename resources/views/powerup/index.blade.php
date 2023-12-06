@extends('layouts.app')
@section('title', 'List of Powerups')

@section('content')
    <h1>Powerups</h1>
    <a href="{{ route('powerups.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($powerups) > 0)
        @foreach ($powerups as $powerup)
            <div>
                <h2>{{ $powerup->name }}</h2>
                <ul>
                    <li>{{ $powerup->price }}🪙</li>
                </ul>
                <p>{{ $powerup->description }}</p>
                <a href="{{ route('powerups.show', ['powerup' => $powerup]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Powerups found!</span>
    @endif
@endsection
