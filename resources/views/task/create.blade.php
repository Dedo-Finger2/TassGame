@extends('layouts.app')
@section('title', 'Create tasks')

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

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ old('exp') }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ old('coins') }}">

        <label for="recurring">Recurring</label>
        @if (old('recurring') == true || old('recurring') === "1")
            <input type="checkbox" checked name="recurring" id="recurring" value="{{ true }}">
        @else
            <input type="checkbox" name="recurring" id="recurring" value="{{ true }}">
        @endif

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>

        <select name="importance_id" id="importance_id">
            @if (count($importances) <= 0)
                <option>None</option>
            @else
                @foreach ($importances as $importance)
                    <option value="{{ $importance->id }}">{{ $importance->name }}</option>
                @endforeach
            @endif
        </select>

        <select name="difficulty_id" id="difficulty_id">
            @if (count($difficulties) <= 0)
                <option>None</option>
            @else
                @foreach ($difficulties as $difficulty)
                    <option value="{{ $difficulty->id }}">{{ $difficulty->name }}</option>
                @endforeach
            @endif
        </select>

        <select name="urgence_id" id="urgence_id">
            @if (count($urgences) <= 0)
                <option>None</option>
            @else
                @foreach ($urgences as $urgence)
                    <option value="{{ $urgence->id }}">{{ $urgence->name }}</option>
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

        <input type="submit" value="Create" name="create" id="create">
    </form>
@endsection
