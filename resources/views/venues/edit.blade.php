@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Venue</h1>

        <form action="{{ route('venues.update', $venue->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $venue->name }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ $venue->address }}" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ $venue->city }}" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" name="state" id="state" class="form-control" value="{{ $venue->state }}" required>
            </div>
            <div class="mb-3">
                <label for="zip" class="form-label">ZIP</label>
                <input type="text" name="zip" id="zip" class="form-control" value="{{ $venue->zip }}" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $venue->telephone }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Venue</button>
        </form>
    </div>
@endsection
