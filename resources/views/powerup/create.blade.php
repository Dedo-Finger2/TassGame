@extends('layouts.app')
@section('title', 'Create item')

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

    <form action="{{ route('powerups.store') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}">


        <label for="type">Type</label>
        <select name="type" id="type">
            <option value="coins">Coins</option>
            <option value="exp">Exp</option>
        </select>

        <label for="uses">Uses</label>
        <input type="number" name="uses" id="uses" value="{{ old('uses') }}">

        <label for="multiplier">Multiplier</label>
        <input type="number" step="0.1" name="multiplier" id="multiplier" value="{{ old('multiplier') }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>

        <input type="submit" value="Create" name="create" id="create">
    </form>
@endsection
