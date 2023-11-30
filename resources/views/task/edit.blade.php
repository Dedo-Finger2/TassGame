@extends('layouts.app')
@section('title', 'Edit tasks')

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

    <form action="{{ route('tasks.update', ['task' => $task]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $task->name }}">

        {{-- <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ old('exp') }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ old('coins') }}"> --}}

        <label for="recurring">Recurring</label>
        @if ($task->recurring == true || $task->recurring === '1')
            <input type="checkbox" checked name="recurring" id="recurring" value="{{ true }}">
        @else
            <input type="checkbox" name="recurring" id="recurring" value="{{ true }}">
        @endif

        <label for="due_date">Due Date</label>
        <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $task->description }}</textarea>

        <select name="importance_id" id="importance_id">
            @if (count($importances) <= 0)
                <option>None</option>
            @else
                @foreach ($importances as $importance)
                    @if ($task->importance->id == $importance->id)
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
                    @if ($task->difficulty->id == $difficulty->id)
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
                    @if ($task->urgence->id == $urgence->id)
                        <option selected value="{{ $urgence->id }}">{{ $urgence->name }}</option>
                    @else
                        <option value="{{ $urgence->id }}">{{ $urgence->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <select name="user_id" id="user_id">
            @if (count($users) <= 0)
                <option>None</option>
            @else
                @foreach ($users as $user)
                    @if ($user->id == auth()->user()->id)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
