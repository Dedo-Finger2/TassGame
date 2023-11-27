@extends('layouts.app')
@section('title', 'Edit urgence')

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

    <form action="{{ route('urgences.update', ['urgence' => $urgence]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $urgence->name }}">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ $urgence->exp }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ $urgence->coins }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $urgence->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
