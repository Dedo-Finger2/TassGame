@extends('layouts.app')
@section('title', 'List of Upgrades')

@section('content')
    <h1>Upgrades</h1>
    <a href="{{ route('upgrades.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($upgrades) > 0)
        @foreach ($upgrades as $upgrade)
            <div>
                <h2>{{ $upgrade->name }}</h2>
                <ul>
                    <li>{{ $upgrade->price }}🪙</li>
                </ul>
                <p>{{ $upgrade->description }}</p>
                <a href="{{ route('upgrades.show', ['upgrade' => $upgrade]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Upgrades found!</span>
    @endif
@endsection
