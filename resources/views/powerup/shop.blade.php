@extends('layouts.app')
@section('title', 'Shop - Powerups')

@section('content')
    <h1>Shop - Powerups</h1>
    <span><a href="{{ route('shop.items') }}">Shop Items</a></span>
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

    <h2>Can buy powerups</h2>
    <span><a href="{{ route('powerups.index') }}">All powerups</a></span>
    <hr>
    @if (count($canBuyPowerups) > 0)
        @foreach ($canBuyPowerups as $key => $powerup)
            <ul>
                <li>{{ $powerup->name }} | {{ $powerup->price }}🪙 | <button id="buy{{ $key }}">Buy</button>
                </li>
            </ul>
            <dialog id="modal-buy{{ $key }}">
                <h1>You sure you want to buy {{ $powerup->name }} for {{ $powerup->price }}🪙?</h1>
                <form action="{{ route('shop.buy', ['item' => $powerup]) }}" method="GET">
                    @csrf
                    <input type="hidden" name="item_type" value="powerup">
                    <button type="submit" id="delete-button">Buy</button>
                </form>
                <br>
                <button id="close-modal{{ $key }}">Close</button>
            </dialog>
        @endforeach
    @else
        <span>No powerups you can afford buying now.</span>
    @endif

    <hr>

    <script>
        @foreach ($canBuyPowerups as $key => $powerup)
            var modal{{ $key }} = document.getElementById("modal-buy{{ $key }}");
            var btn{{ $key }} = document.getElementById("buy{{ $key }}");
            var btn_close{{ $key }} = document.getElementById("close-modal{{ $key }}");

            btn{{ $key }}.onclick = function() {
                modal{{ $key }}.showModal();
            }

            btn_close{{ $key }}.onclick = function() {
                modal{{ $key }}.close();
            }

            window.onclick = function(event) {
                if (event.target == modal{{ $key }}) {
                    modal{{ $key }}.close();
                }
            }
        @endforeach
    </script>

@endsection
