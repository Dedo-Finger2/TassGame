@extends('layouts.app')
@section('title', 'List of Items')

@section('content')
    <h1>Items</h1>
    <a href="{{ route('items.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <hr>
    @if (count($items) > 0)
        @foreach ($items as $item)
            <div>
                <h2>{{ $item->name }}</h2>
                <ul>
                    <li>{{ $item->price }}🪙</li>
                </ul>
                <p>{{ $item->description }}</p>
                <a href="{{ route('items.show', ['item' => $item]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Items found!</span>
    @endif
@endsection
