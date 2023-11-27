@extends('layouts.app')

@section('content')
    <h1>Welcome</h1><span>Name: {{ auth()->user()->name }}</span>

    <div>
        @if (session('success'))
            <span>{{ session('success') }}</span>
        @endif
    </div>
@endsection
