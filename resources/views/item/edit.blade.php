@extends('layouts.app')
@section('title', 'Edit item')

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

    <form action="{{ route('items.update', ['item' => $item]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ $item->name }}">

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ $item->price }}">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ $item->description }}</textarea>

        <input type="submit" value="Edit" name="edit" id="edit">
    </form>
@endsection
