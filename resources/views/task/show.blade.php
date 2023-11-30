@extends('layouts.app')
@section('title', 'Show Task')

@section('content')
    <h1>
        {{ $task->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('tasks.edit', ['task' => $task]) }}">Edit</a>

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

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
        <li>🔁: @if ($task->recurring)
                True
            @else
                False
            @endif
        </li>
        <li>✅: @if ($task->completed_at)
                {{ $task->completed_at }}
            @else
                No
            @endif
        </li>
        <li>🗓️: @if ($task->due_date != null){{ $task->due_date }} @else ❌ @endif </li>
    </ul>
    <textarea readonly disabled name="description" id="description" cols="30" rows="10">{{ $task->description }}</textarea>
    <hr>

    @if (count($subTasks) > 0)
        <h2>Subtasks Related:</h2>

        <form action="{{ route('sub-tasks.complete') }}" id="formId" method="POST">
            @csrf

            @foreach ($subTasks as $subTask)
                <input type="checkbox" value="{{ $subTask->id }}" name="subTasks[]" id="subTask{{ $subTask->id }}">
                {{ $subTask->name }}
                |
                {{ $subTask->exp }}✨ | {{ $subTask->coins }}🪙 | <a
                    href="{{ route('sub-tasks.show', ['sub_task' => $subTask]) }}">View</a><br>
            @endforeach
            <br>
            <input type="submit" name="complete Subtasks" value="Complete Subtasks" id="complete-Subtasks">
        @else
            <span>No SubTasks found!</span>
    @endif

    @if (count($completedSubTasks) > 0)
        <hr>
        <h2>Completed Subtasks</h2>

        <form action="{{ route('sub-tasks.uncomplete') }}" id="formId" method="POST">
            @csrf

            @foreach ($completedSubTasks as $subTask)
                <input type="checkbox" value="{{ $subTask->id }}" name="subTasks[]" id="subTask{{ $subTask->id }}">
                {{ $subTask->name }}
                | {{ $subTask->completed_at }} | <a
                    href="{{ route('sub-tasks.show', ['sub-task' => $subTask]) }}">View</a><br>
            @endforeach
            <br>
            <input type="submit" name="uncomplete Subtasks" value="Uncomplete Subtasks" id="uncomplete-Subtasks">
        @else
            <span><br><br>No completed SubTasks found!</span>
    @endif

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

        document.getElementById('complete-Subtasks').onclick = function() {
            document.getElementById('formId').action = "{{ route('sub-tasks.complete') }}";
        }

        document.getElementById('uncomplete-Subtasks').onclick = function() {
            document.getElementById('formId').action = "{{ route('sub-tasks.uncomplete') }}";
        }
    </script>

@endsection
