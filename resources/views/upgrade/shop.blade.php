@extends('layouts.app')
@section('title', 'Shop - Upgrades')

@section('content')
    <h1>Shop - Upgrades</h1>
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

    <h2>Can buy upgrades</h2>
    <span><a href="{{ route('upgrades.index') }}">All upgrades</a></span>
    <hr>
    @if (count($canBuyUpgrades) > 0)
        @foreach ($canBuyUpgrades as $key => $upgrade)
            <ul>
                <li>{{ $upgrade->name }} | {{ $upgrade->price }}🪙 |
                    @if ($upgrade->can_buy == false)
                        <button disabled id="buy{{ $key }}">Buy</button> | [MAXED]
                    @else
                        <button id="buy{{ $key }}">Buy</button>
                    @endif
                </li>
            </ul>
            <dialog id="modal-buy{{ $key }}">
                <h1>You sure you want to buy {{ $upgrade->name }} for {{ $upgrade->price }}🪙?</h1>
                <form action="{{ route('shop.buy', ['item' => $upgrade]) }}" method="GET">
                    @csrf
                    <input type="hidden" name="item_type" value="upgrade">
                    <button type="submit" id="delete-button">Buy</button>
                </form>
                <br>
                <button id="close-modal{{ $key }}">Close</button>
            </dialog>
        @endforeach
    @else
        <span>No upgrades you can afford buying now.</span>
    @endif

    <hr>

    <script>
        @foreach ($canBuyUpgrades as $key => $upgrade)
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
