@extends('layouts.app')
@section('title', 'Create difficulty')

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

    <form action="{{ route('difficulties.store') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ old('exp') }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ old('coins') }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>

        <input type="submit" value="Create" name="create" id="create">
    </form>
@endsection
