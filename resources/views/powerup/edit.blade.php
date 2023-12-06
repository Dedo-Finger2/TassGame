@extends('layouts.app')
@section('title', 'Edit powerup')

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

    <form action="{{ route('powerups.update', ['powerup' => $powerup]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $powerup->name }}">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ $powerup->price }}">


        <label for="type">Type</label>
        <select name="type" id="type">
            <option selected value="{{ $powerup->type }}">{{ $powerup->type }}</option>
            <option value="coins">Coins</option>
            <option value="exp">Exp</option>
        </select>

        <label for="duration">Duration</label>
        <input type="number" name="duration" id="duration" value="{{ $powerup->duration }}">

        <label for="multiplier">Multiplier</label>
        <input type="number" step="0.1" name="multiplier" id="multiplier" value="{{ $powerup->multiplier }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $powerup->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
