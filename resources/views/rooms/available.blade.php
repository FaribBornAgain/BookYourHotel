<!-- resources/views/rooms/available.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Available Rooms</h2>

    @if(isset($rooms) && count($rooms) > 0)
        <ul>
            @foreach($rooms as $room)
                <li>{{ $room->name }} - {{ $room->price }} BDT</li>
            @endforeach
        </ul>
    @else
        <p>No rooms available for your search.</p>
    @endif
</div>
@endsection
