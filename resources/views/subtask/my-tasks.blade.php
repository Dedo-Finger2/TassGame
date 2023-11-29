@extends('layouts.app')
@section('title', 'List of My Tasks')

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

    @if (count($todayTasks) > 0)
        <h2>Today's tasks</h2>

        <form action="{{ route('tasks.complete-tasks') }}" method="POST">
            @csrf

            @foreach ($todayTasks as $task)
                <input type="checkbox" value="{{ $task->id }}" name="tasks[]" id="task"> {{ $task->name }} |
                {{ $task->exp }}✨ | {{ $task->coins }}🪙 | <a
                    href="{{ route('tasks.show', ['task' => $task]) }}">View</a><br>
            @endforeach
        @else
            <span>No Tasks for today found!</span>
    @endif

    @if (count($recurringTasks) > 0)
        <h2>Today's recurring tasks</h2>

        @foreach ($recurringTasks as $task)
            <input type="checkbox" value="{{ $task->id }}" name="tasks[]" id="task"> {{ $task->name }} |
            {{ $task->exp }}✨ | {{ $task->coins }}🪙 | <a
                href="{{ route('tasks.show', ['task' => $task]) }}">View</a><br>
        @endforeach

        <br><br>
    @else
        <br><span>No Recurring Tasks found!</span>
    @endif
    @if (count($todayTasks) > 0 || count($recurringTasks) > 0)
        <input type="submit" value="Complete Selected tasks" name="complete-button" id="complete-button">
    @endif
    </form>


    <br><br>



@endsection
