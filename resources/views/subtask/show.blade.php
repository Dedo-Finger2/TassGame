@extends('layouts.app')
@section('title', 'Show Task')

@section('content')
    <h1>{{ $task->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('tasks.edit', ['task' => $task]) }}">Edit</a>
    <hr>

    <dialog id="modal-deletion">
        <h1>You sure you want to delete {{ $task->name }}?</h1>
        <form action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-button">Delete</button>
        </form>
        <br>
        <button id="close-modal">Close</button>
    </dialog>

    <h2>Status:</h2>
    <ul>
        <li>{{ $task->coins }}🪙</li>
        <li>{{ $task->exp }}✨</li>
        <li>🔁: @if ($task->recurring) True @else False @endif</li>
        <li>✅: @if ($task->completed_at) {{ $task->completed_at }} @else No @endif</li>
    </ul>
    <textarea readonly disabled name="description" id="description" cols="30" rows="10">{{ $task->description }}</textarea>
    <hr>
    <h2>Subtasks Related:</h2>
    <ul>
        <li>...</li>
    </ul>

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
