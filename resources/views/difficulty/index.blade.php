@extends('layouts.app')
@section('title', 'List of urgences')

@section('content')
    <h1>Urgences</h1>
    <a href="{{ route('urgences.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($urgences) > 0)
        @foreach ($urgences as $urgence)
            <div>
                <h2>{{ $urgence->name }}</h2>
                <ul>
                    <li>{{ $urgence->exp }}✨</li>
                    <li>{{ $urgence->coins }}🪙</li>
                </ul>
                <p>{{ $urgence->description }}</p>
                <a href="{{ route('urgences.show', ['urgence' => $urgence]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Urgence found!</span>
    @endif
@endsection
