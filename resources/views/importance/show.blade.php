@extends('layouts.app')
@section('title', 'Show importance')

@section('content')
    <h1>{{ $importance->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('importances.edit', ['importance' => $importance]) }}">Edit</a>
    <hr>

    <div id="modal-deletion" style="display: none; z-index: 1; border: 1px solid black; padding: 20px">
        <h1>You sure you want to delete {{ $importance->name }}?</h1>
        <form action="{{ route('importances.destroy', ['importance' => $importance]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-button">Delete</button>
        </form>
        <br>
        <button id="close-modal">Close</button>
    </div>

    <ul>
        <li>This importance boost your tasks with {{ $importance->coins }}🪙</li>
        <li>This importance boost your tasks with {{ $importance->exp }}✨</li>
        <li>Description: {{ $importance->description }}</li>
    </ul>

    <script>
        var modal = document.getElementById("modal-deletion");
        var btn = document.getElementById("confirm-delete");
        var btn_close = document.getElementById("close-modal");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        btn_close.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

@endsection
