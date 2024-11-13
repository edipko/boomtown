@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Dashboard</h1>

        <!-- Link to go back to the main public page -->
        <div class="mb-4">
            <a href="{{ url('/') }}" class="btn btn-secondary">Back to Public View</a>
        </div>

        <div class="list-group">
            <a href="{{ route('events.index') }}" class="list-group-item list-group-item-action">
                Manage Events
            </a>
            <a href="{{ route('venues.index') }}" class="list-group-item list-group-item-action">
                Manage Venues
            </a>
            <a href="{{ route('mailing-list.index') }}" class="list-group-item list-group-item-action">
                Manage Mailing List
            </a>
            <a href="{{ route('content.edit') }}" class="list-group-item list-group-item-action">
                Manage Website Content
            </a>
            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                Manage Users
            </a>
        </div>
    </div>
@endsection
