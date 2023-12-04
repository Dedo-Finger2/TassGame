@extends('layouts.app')
@section('title', 'Shop')

@section('content')
    <h1>Shop</h1>
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

    <h2>Can buy items</h2>
    @if (count($canBuyItems) > 0)
        @foreach ($canBuyItems as $key => $item)
            <ul>
                <li>{{ $item->name }} | {{ $item->price }}🪙 | <button id="buy{{ $key }}">Buy</button>
                </li>
            </ul>
            <dialog id="modal-buy{{ $key }}">
                <h1>You sure you want to buy {{ $item->name }} for {{ $item->price }}🪙?</h1>
                <form action="{{ route('shop.buy', ['item' => $item]) }}" method="GET">
                    @csrf
                    <button type="submit" id="delete-button">Buy</button>
                </form>
                <br>
                <button id="close-modal{{ $key }}">Close</button>
            </dialog>
        @endforeach
    @else
        <span>No items you can afford buying now.</span>
    @endif

    <hr>

    <h2>All items</h2>
    @if (count($items) > 0)
        @foreach ($items as $item)
            <ul>
                <li>{{ $item->name }} | {{ $item->price }}🪙</li>
            </ul>
        @endforeach
    @else
        <span>No items found. <a href="{{ route('items.create') }}">Create a new item!</a></span>
    @endif

    <script>
        @foreach ($canBuyItems as $key => $item)
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
