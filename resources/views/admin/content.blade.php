@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-12">
        <h2 class="text-2xl font-bold mb-6">Manage Website Content</h2>

        @if(session('success'))
            <div class="mb-4 text-green-500">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.content.update') }}" method="POST">
        @csrf

        <!-- About Content Section -->
            <div class="mb-6">
                <label for="about_content" class="block text-lg font-medium">About Boomtown Section</label>
                <textarea name="about_content" id="about_content" class="w-full p-4 mt-2 rounded-lg" rows="5">{{ old('about_content', $aboutContent->content) }}</textarea>
            </div>

            <!-- Facebook Link Section -->
            <div class="mb-6">
                <label for="facebook_link" class="block text-lg font-medium">Facebook Link</label>
                <input type="text" name="facebook_link" id="facebook_link" class="w-full p-4 mt-2 rounded-lg" value="{{ old('facebook_link', $facebookLink->content ?? '') }}">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Update Content</button>
        </form>
    </div>
@endsection
