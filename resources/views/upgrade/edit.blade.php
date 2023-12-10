@extends('layouts.app')
@section('title', 'Edit Upgrade')

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

    <form action="{{ route('upgrades.update', ['upgrade' => $upgrade]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $upgrade->name }}">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ $upgrade->price }}">

        <label for="multiplier">Multiplier</label>
        <input type="number" step="0.1" name="multiplier" id="multiplier" value="{{ $upgrade->multiplier }}">

        <label for="level">Level</label>
        <input type="number" name="level" id="level" value="{{ $upgrade->level }}">

        <label for="image">Image</label>
        <input type="file" name="image" id="image" value="{{ $upgrade->image }}">

        <label for="price_multiplier_per_buy">Price Multiplier Per Buy</label>
        <input type="number" step="0.1" name="price_multiplier_per_buy" id="price_multiplier_per_buy" value="{{ $upgrade->price_multiplier_per_buy }}">

        <label for="buy_limit">Buy Limit</label>
        <input type="number" name="buy_limit" id="buy_limit" value="{{ $upgrade->buy_limit }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $upgrade->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
