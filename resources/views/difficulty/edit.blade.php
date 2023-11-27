@extends('layouts.app')
@section('title', 'Edit difficulty')

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

    <form action="{{ route('difficulties.update', ['difficulty' => $difficulty]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $difficulty->name }}">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ $difficulty->exp }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ $difficulty->coins }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $difficulty->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
