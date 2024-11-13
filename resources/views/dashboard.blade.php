@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Dashboard</h1>
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
        </div>
    </div>
@endsection
