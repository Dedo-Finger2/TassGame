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
                    <td>{{ $name }} <strong>x{{ $itemGroup->count() }}</strong> </td>
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
                    <td>{{ $name }} <strong>x{{ $powerupGroup->count() }}</strong> </td>
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
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Level Req.</th>
                <th>Multiplier</th>
                <th>Options</th>
            </tr>
            @foreach ($userInventory->upgrades->groupBy('name') as $name => $upgradeGroup)
                <tr>
                    <td># {{ $upgradeGroup->first()->id }}</td>
                    <td><img src="img/upgrades/{{ $upgradeGroup->first()->image }}" alt="image" style="width: 50px"></td>
                    <td>{{ $name }} <strong>x{{ $upgradeGroup->count() }}</strong></td>
                    <td>{{ $upgradeGroup->first()->price }}🪙 </td>
                    <td>{{ $upgradeGroup->first()->level }}🌳 </td>
                    <td>{{ $upgradeGroup->first()->multiplier }}✖️ </td>
                    <td><a href="{{ route('upgrades.show', ['upgrade' => $upgradeGroup->first()]) }}">View</a>
                </tr>
            @endforeach
        </table>
    @else
        <span>You bought no upgrades just yet.</span>
    @endif
    <hr>

    {{-- Active Powerups --}}
    <h2>Active Powerups:</h2>
    @if (isset($activePowerups) && count($activePowerups) > 0)
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Uses Left</th>
                <th>Type</th>
                <th>Multiplier</th>
                <th>Options</th>
            </tr>
            @foreach ($activePowerups->groupBy('name') as $name => $powerupGroup)
                <tr>
                    <td># {{ $powerupGroup->first()->id }}</td>
                    <td>{{ $name }} x{{ $powerupGroup->count() }} </td>
                    <td>{{ $powerupGroup->first()->remaining_uses }}⌛ </td>
                    <td>{{ $powerupGroup->first()->type }} </td>
                    <td>{{ $powerupGroup->first()->multiplier }}✖️ </td>
                    <td><a href="{{ route('powerups.show', ['powerup' => $powerupGroup->first()]) }}">View</a>
                </tr>
            @endforeach
        </table>
    @else
        <span>You have no powerup active at the moment.</span>
    @endif

@endsection
