@extends('layouts.app')
@section('title', 'Show upgrade')

@section('content')
    <h1>{{ $upgrade->name }}</h1>
    <button id="confirm-delete">Delete</button> - <a href="{{ route('upgrades.edit', ['upgrade' => $upgrade]) }}">Edit</a>
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
        <h1>You sure you want to delete {{ $upgrade->name }}?</h1>
        <form action="{{ route('upgrades.destroy', ['upgrade' => $upgrade]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-button">Delete</button>
        </form>
        <br>
        <button id="close-modal">Close</button>
    </dialog>

    <label for="details">Details:</label>
    <br>
    <img src="/img/upgrades/{{ $upgrade->image }}" alt="image" style="width: 150px">
    <ul>
        <li>This upgrade cost: {{ $upgrade->price }}🪙</li>
        <li>Multiplier: {{ $upgrade->multiplier }}✖️</li>
        <li>Level needed: {{ $upgrade->level }}🌳</li>
        <li>PMPB: {{ $upgrade->price_multiplier_per_buy }}✖️💴</li>
        <li>Limit: {{ $upgrade->buy_limit }}</li>
        <li>How many you got: {{ $userUpgradeBoughtAmount }}</li>
        @if ($upgrade->can_buy != null)
            <li>Can Buy: ✅</li>
        @else
            <li>Can Buy: ❌</li>
        @endif
        <li>Upgrade created at: {{ $upgrade->created_at }}</li>
    </ul>

    <label for="description">Description:</label><br>
    <textarea name="description" disabled id="description" cols="30" rows="10">{{ $upgrade->description }}</textarea>



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
