@extends('layouts.app')
@section('title', 'Show item')

@section('content')
    <h1>{{ $item->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('items.edit', ['item' => $item]) }}">Edit</a>
    <hr>

    <dialog id="modal-deletion">
        <h1>You sure you want to delete {{ $item->name }}?</h1>
        <form action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-button">Delete</button>
        </form>
        <br>
        <button id="close-modal">Close</button>
    </dialog>

    <ul>
        <li>This item cost: {{ $item->price }}🪙</li>
        <li>Item created at: {{ $item->created_at }}</li>
    </ul>

    <textarea name="description" disabled id="" cols="30" rows="10">{{ $item->description }}</textarea>

    <script>
                var modal = document.getElementById("modal-deletion");
        var btn = document.getElementById("confirm-delete");
        var btn_close = document.getElementById("close-modal");

        btn.onclick = function() {
            modal.showModal();
        }

        btn_close.onclick = function() {
            modal.close();
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.close();
            }
        }
    </script>

@endsection
