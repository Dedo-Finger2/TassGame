@extends('layouts.app')
@section('title', 'My Iventory')

@section('content')
    <h1>Iventory</h1>
    <hr>

    @if (session('error'))
        <div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Items --}}
    <h2>Items:</h2>
    @if (isset($userInventory->items) && count($userInventory->items) > 0)
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Price</th>
                <th>Options</th>
            </tr>
            @foreach ($userInventory->items->groupBy('name') as $name => $itemGroup)
                <tr>
                    <td># {{ $itemGroup->first()->id }}</td>
                    <td>{{ $name }} x{{ $itemGroup->count() }} </td>
                    <td>{{ $itemGroup->first()->price }}🪙 </td>
                    <td><a href="{{ route('items.show', ['item' => $itemGroup->first()]) }}">View</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <span>You bought no items just yet.</span>
    @endif

    {{-- Powerups --}}
    <h2>Powerups:</h2>
    @if (isset($userInventory->powerups) && count($userInventory->powerups) > 0)
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Price</th>
                <th>Uses</th>
                <th>Type</th>
                <th>Multiplier</th>
                <th>Options</th>
            </tr>
            @foreach ($userInventory->powerups->groupBy('name') as $name => $powerupGroup)
                <tr>
                    <td># {{ $powerupGroup->first()->id }}</td>
                    <td>{{ $name }} x{{ $powerupGroup->count() }} </td>
                    <td>{{ $powerupGroup->first()->price }}🪙 </td>
                    <td>{{ $powerupGroup->first()->uses }}⌛ </td>
                    <td>{{ $powerupGroup->first()->type }} </td>
                    <td>{{ $powerupGroup->first()->multiplier }}✖️ </td>
                    <td><a href="{{ route('powerups.show', ['powerup' => $powerupGroup->first()]) }}">View</a>|<a
                            href="{{ route('powerups.use', ['powerup' => $powerupGroup->first()]) }}">Use</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <span>You bought no powerups just yet.</span>
    @endif

    {{-- Upgrades --}}
    <h2>Upgrades:</h2>
    @if (isset($userInventory->upgrades) && count($userInventory->upgrades) > 0)
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Price</th>
                <th>Options</th>
            </tr>
            @foreach ($userInventory->upgrades as $upgrade)
                <tr>
                    <td># {{ $upgrade->id }}</td>
                    <td>{{ $upgrade->name }} </td>
                    <td>{{ $upgrade->price }}🪙 </td>
                    <td><a href="#">View</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <span>You bought no upgrades just yet.</span>
    @endif

@endsection
