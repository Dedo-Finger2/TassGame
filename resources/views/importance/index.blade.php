@extends('layouts.app')
@section('title', 'List of importances')

@section('content')
    <h1>Importances</h1>
    <a href="{{ route('importances.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($importances) > 0)
        @foreach ($importances as $importance)
            <div>
                <h2>{{ $importance->name }}</h2>
                <ul>
                    <li>{{ $importance->exp }}✨</li>
                    <li>{{ $importance->coins }}🪙</li>
                </ul>
                <p>{{ $importance->description }}</p>
                <a href="{{ route('importances.show', ['importance' => $importance]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Importance found!</span>
    @endif
@endsection
