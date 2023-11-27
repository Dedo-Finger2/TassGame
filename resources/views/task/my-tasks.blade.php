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

    <hr>
    @if (count($todayTasks) > 0)
        <h2>Today's tasks</h2>
        @foreach ($todayTasks as $task)
            <div>
                <h2>{{ $task->name }}</h2>
                <a href="{{ route('tasks.show', ['task' => $task]) }}">View</a>
            </div>
            <hr>
        @endforeach
    @else
        <span>No Tasks for today found!</span>
    @endif
    <br><br>
    @if (count($recurringTasks) > 0)
        <h2>Today's recurring tasks</h2>
        @foreach ($recurringTasks as $task)
            <div>
                <h2>{{ $task->name }}</h2>
                <a href="{{ route('tasks.show', ['task' => $task]) }}">View</a>
            </div>
        @endforeach
        <hr>
    @else
        <span>No Recurring Tasks found!</span>
    @endif
@endsection
