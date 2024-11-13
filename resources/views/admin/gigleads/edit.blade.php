@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Gig Lead</h1>
        <form action="{{ route('gigleads.update', $gigLead) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $gigLead->name }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $gigLead->email }}">
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $gigLead->telephone }}">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes">{{ $gigLead->notes }}</textarea>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="followed_up" name="followed_up" value="1" {{ $gigLead->followed_up ? 'checked' : '' }}>
                <label class="form-check-label" for="followed_up">Followed Up</label>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('gigleads.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
