@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Event</h1>

        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="venue_id" class="form-label">Venue</label>
                <select name="venue_id" id="venue_id" class="form-control" required>
                    <option value="">Select Venue</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}" {{ $event->venue_id == $venue->id ? 'selected' : '' }}>
                            {{ $venue->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Event Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $event->name }}" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $event->date }}" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Time</label>
                <input type="time" name="time" id="time" class="form-control" value="{{ $event->time }}" required>
            </div>
            <div class="mb-3">
                <label for="admission_cost" class="form-label">Admission Cost</label>
                <input type="number" step="0.01" name="admission_cost" id="admission_cost" class="form-control" value="{{ $event->admission_cost }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>
@endsection
