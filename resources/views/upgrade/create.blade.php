@extends('layouts.app')
@section('title', 'Create Upgrade')

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

    <form action="{{ route('upgrades.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">

        <label for="image">Image</label>
        <input type="file" name="image" id="image" value="{{ old('image') }}">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}">

        <label for="level">Level</label>
        <input type="number" name="level" id="level" value="{{ old('level') }}">

        <label for="action_value">Action Value</label>
        <input type="number" name="action_value" id="action_value" value="{{ old('action_value') }}">

        <label for="multiplier">Multiplier</label>
        <input type="number" step="0.1" name="multiplier" id="multiplier" value="{{ old('multiplier') }}">

        <label for="price_multiplier_per_buy">Price Multiplier Per Buy</label>
        <input type="number" step="0.1" name="price_multiplier_per_buy" id="price_multiplier_per_buy" value="{{ old('price_multiplier_per_buy') }}">

        <label for="buy_limit">Buy Limit</label>
        <input type="number" name="buy_limit" id="buy_limit" value="{{ old('buy_limit') }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>

        <input type="submit" value="Create" name="create" id="create">
    </form>
@endsection
