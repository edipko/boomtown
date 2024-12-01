@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="display-4 mb-4">Manage Website Content</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('content.update') }}" method="POST">
        @csrf

        <!-- About Content Section -->
            <div class="form-group">
                <label for="content">About Section Content</label>
                <textarea class="form-control" id="content" name="content" rows="6">{{ old('content', $aboutContent->content ?? '') }}</textarea>
            </div>

            <!-- Facebook Link Section -->
            <div class="form-group">
                <label for="facebook_link">Facebook Link</label>
                <input type="text" class="form-control" id="facebook_link" name="facebook_link" value="{{ old('facebook_link', $facebookLink->content ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Content</button>
        </form>
    </div>
@endsection
