@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Dashboard</h1>

        <!-- Link to go back to the main public page -->
        <div class="mb-4">
            <a href="{{ url('/') }}" class="btn btn-secondary">Back to Public View</a>
        </div>

        <!-- Manage Gigs Section -->
        <div class="mb-4">
            <h2 class="h5 font-weight-bold mb-3">Manage Gigs</h2>
            <div class="list-group">
                <a href="{{ route('venues.index') }}" class="list-group-item list-group-item-action">
                    Manage Venues
                </a>
                <a href="{{ route('events.index') }}" class="list-group-item list-group-item-action">
                    Manage Events
                </a>
            </div>
        </div>

        <!-- Manage Website Section -->
        <div class="mb-4">
            <h2 class="h5 font-weight-bold mb-3">Manage Website</h2>
            <div class="list-group">
                <a href="{{ route('content.edit') }}" class="list-group-item list-group-item-action">
                    Manage About
                </a>
            </div>
        </div>

        <!-- Manage Users Section -->
        <div class="mb-4">
            <h2 class="h5 font-weight-bold mb-3">Manage Users</h2>
            <div class="list-group">
                <a href="{{ route('mailing-list.index') }}" class="list-group-item list-group-item-action">
                    Manage Mailing List
                </a>
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                    Manage Admins
                </a>
            </div>
        </div>

        <!-- Gig Leads Section -->
        <div class="mb-4">
            <h2 class="h5 font-weight-bold mb-3">Gig Leads</h2>
            <div class="list-group">
                <a href="{{ route('gigleads.index') }}" class="list-group-item list-group-item-action">
                    Manage Gig Leads
                </a>
            </div>
        </div>

    </div>
@endsection
