@extends('layouts.app')
@section('title', 'Edit importance')

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

    <form action="{{ route('importances.update', ['importance' => $importance]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $importance->name }}">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp" value="{{ $importance->exp }}">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins" value="{{ $importance->coins }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $importance->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
