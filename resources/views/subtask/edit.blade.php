@extends('layouts.app')
@section('title', 'Edit SubTask')

@section('content')

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sub-tasks.update', ['sub_task' => $subTask]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $subTask->name }}">

        {{-- <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ old('exp') }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ old('coins') }}"> --}}

        {{-- <label for="recurring">Recurring</label>
        @if ($subTask->recurring == true || $subTask->recurring === '1')
            <input type="checkbox" checked name="recurring" id="recurring" value="{{ true }}">
        @else
            <input type="checkbox" name="recurring" id="recurring" value="{{ true }}">
        @endif --}}

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $subTask->description }}</textarea>

        <select name="importance_id" id="importance_id">
            @if (count($importances) <= 0)
                <option>None</option>
            @else
                @foreach ($importances as $importance)
                    @if ($subTask->importance->id == $importance->id)
                        <option selected value="{{ $importance->id }}">{{ $importance->name }}</option>
                    @else
                        <option value="{{ $importance->id }}">{{ $importance->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <select name="difficulty_id" id="difficulty_id">
            @if (count($difficulties) <= 0)
                <option>None</option>
            @else
                @foreach ($difficulties as $difficulty)
                    @if ($subTask->difficulty->id == $difficulty->id)
                        <option selected value="{{ $difficulty->id }}">{{ $difficulty->name }}</option>
                    @else
                        <option value="{{ $difficulty->id }}">{{ $difficulty->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <select name="urgence_id" id="urgence_id">
            @if (count($urgences) <= 0)
                <option>None</option>
            @else
                @foreach ($urgences as $urgence)
                    @if ($subTask->urgence->id == $urgence->id)
                        <option selected value="{{ $urgence->id }}">{{ $urgence->name }}</option>
                    @else
                        <option value="{{ $urgence->id }}">{{ $urgence->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <select name="task_id" id="task_id">
            @if (count($tasks) <= 0)
                <option>None</option>
            @else
                @foreach ($tasks as $task)
                    @if ($task->id == $subTask->task->id)
                        <option selected value="{{ $task->id }}">{{ $task->name }}</option>
                    @else
                        <option value="{{ $task->id }}">{{ $task->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
