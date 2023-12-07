@extends('layouts.app')
@section('title', 'Show powerup')

@section('content')
    <h1>{{ $powerup->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('powerups.edit', ['powerup' => $powerup]) }}">Edit</a>
    <hr>

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

    <dialog id="modal-deletion">
        <h1>You sure you want to delete {{ $powerup->name }}?</h1>
        <form action="{{ route('powerups.destroy', ['powerup' => $powerup]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-button">Delete</button>
        </form>
        <br>
        <button id="close-modal">Close</button>
    </dialog>

    <label for="details">Details:</label>
    <ul>
        <li>This powerup cost: {{ $powerup->price }}🪙</li>
        <li>Uses: {{ $powerup->uses }}⌛</li>
        <li>Multiplier: {{ $powerup->multiplier }}✖️</li>
        <li>Type: {{ $powerup->type }}</li>
        @if ($powerup->bought != null)
            <li>Bought: ✅</li>
            <li>Bought Date: {{ $powerup->bought_date }}🗓️</li>
        @else
            <li>Bought: ❌</li>
        @endif
        <li>Powerup created at: {{ $powerup->created_at }}</li>
    </ul>

    <label for="description">Description:</label><br>
    <textarea name="description" disabled id="description" cols="30" rows="10">{{ $powerup->description }}</textarea>

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
