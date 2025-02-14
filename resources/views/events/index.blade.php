@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Manage Events</h1>
    @livewire('manage-events')  <!-- Livewire Component -->
    </div>
@endsection
