@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Add New Event</a>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Admission Cost</th>
                <th>Venue</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->time }}</td>
                    <td>{{ $event->admission_cost }}</td>
                    <td>{{ $event->venue->name }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
