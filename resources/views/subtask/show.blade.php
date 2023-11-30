@extends('layouts.app')
@section('title', 'Show SubTask')

@section('content')
    <h1>{{ $subTask->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('sub-tasks.edit', ['sub_task' => $subTask]) }}">Edit</a>
    <hr>

    <dialog id="modal-deletion">
        <h1>You sure you want to delete {{ $subTask->name }}?</h1>
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
        <li>{{ $subTask->coins }}🪙</li>
        <li>{{ $subTask->exp }}✨</li>
        <li>✅: @if ($subTask->completed_at) {{ $subTask->completed_at }} @else No @endif</li>
    </ul>
    <textarea readonly disabled name="description" id="description" cols="30" rows="10">{{ $subTask->description }}</textarea>
    <hr>
    <h2>Task Releated:</h2>
    <ul>
        <li>{{ $subTask->task->name }} | <a href="{{ route('tasks.show', ['task' => $subTask->task]) }}">View</a></li>
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
