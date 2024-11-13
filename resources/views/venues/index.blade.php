@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Venues</h1>
        <a href="{{ route('venues.create') }}" class="btn btn-primary">Add New Venue</a>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Telephone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($venues as $venue)
                <tr>
                    <td>{{ $venue->name }}</td>
                    <td>{{ $venue->address }}</td>
                    <td>{{ $venue->city }}</td>
                    <td>{{ $venue->state }}</td>
                    <td>{{ $venue->zip }}</td>
                    <td>{{ $venue->telephone }}</td>
                    <td>
                        <a href="{{ route('venues.edit', $venue->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" style="display: inline-block;">
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
