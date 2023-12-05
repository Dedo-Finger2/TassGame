@extends('layouts.app')
@section('title', 'My Iventory')

@section('content')
    <h1>Iventory</h1>
    <hr>

    <h2>Items:</h2>
    @if (count($userInventory->items) <= 0)
        <span>You bought no items just yet.</span>
    @else
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
                    <td><a href="#">View</a></td>
                </tr>
            @endforeach
        </table>
    @endif

    <h2>Powerups:</h2>
    @if (count($userInventory->powerups) <= 0)
        <span>You bought no powerups just yet.</span>
    @else
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Price</th>
                <th>Options</th>
            </tr>
            @foreach ($userInventory->powerups as $powerup)
                <tr>
                    <td># {{ $powerup->id }}</td>
                    <td>{{ $powerup->name }} </td>
                    <td>{{ $powerup->price }}🪙 </td>
                    <td><a href="#">View</a></td>
                </tr>
            @endforeach
        </table>
    @endif

    <h2>Upgrades:</h2>
    @if (count($userInventory->upgrades) <= 0)
        <span>You bought no upgrades just yet.</span>
    @else
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
    @endif

@endsection
