@extends('layouts.app')
@section('title', 'Create xxx')

@section('content')
    <form action="" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" name="name" id="name">

        <label for="exp">Exp</label>
        <input type="number" name="exp" id="exp">

        <label for="coins">Coins</label>
        <input type="number" name="coins" id="coins">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>

        <input type="submit" value="Create" name="create" id="create">
    </form>
@endsection
