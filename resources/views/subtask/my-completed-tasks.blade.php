@extends('layouts.app')
@section('title', 'List of My Tasks')

@section('content')
    <h1>Tasks</h1>
    <a href="{{ route('tasks.my-tasks') }}">Complete some tasks</a>

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

    @if (count($completedTasks) > 0)
    <h1>Completed</h2>
        <form action="{{ route('tasks.uncomplete-tasks') }}" method="POST">
            @csrf
            @foreach ($completedTasks as $task)
                <input type="checkbox" value="{{ $task->id }}" name="tasks[]" id="task">
                {{ $task->name }} | {{ $task->completed_at }} | Recurring = @if ($task->recurring)
                    True
                @else
                    False
                @endif | <a href="{{ route('tasks.show', ['task' => $task]) }}">View</a> <br>
            @endforeach
            <br><br>
            <input type="submit" value="Un-complete tasks" name="un-complete-button" id="un-complete-button">
        </form>
    @else
        <span>No Tasks completed found!</span>
    @endif

@endsection

