@extends('layouts.app')
@section('title', 'List of Tasks')

@section('content')
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}">Create new</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <hr>
    @if (count($tasks) > 0)
        @foreach ($tasks as $task)
            <div>
                <h2>{{ $task->name }}</h2>
                <a href="{{ route('tasks.show', ['task' => $task]) }}">View</a>
            </div>
            <hr>
        @endforeach
        <hr>
    @else
        <span>No Tasks found!</span>
    @endif
@endsection
