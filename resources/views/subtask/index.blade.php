@extends('layouts.app')
@section('title', 'List of SubTasks')

@section('content')
    <h1>SubTasks</h1>
    <a href="{{ route('sub-tasks.create', ['selectedTask' => 0]) }}">Create new</a>

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
    @if (count($subTasks) > 0)
        @foreach ($subTasks as $subTask)
            <div>
                <h2>{{ $subTask->name }}</h2>
                <a href="{{ route('sub-tasks.show', ['sub_task' => $subTask]) }}">View</a>
            </div>
            <hr>
        @endforeach
        <hr>
    @else
        <span>No Sub-Tasks found!</span>
    @endif
@endsection
