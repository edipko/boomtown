@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Mailing List Management</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('mailing-list.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Email Sending Form -->
        <h3 class="mt-5">Send Email to Mailing List</h3>
        <form action="{{ route('mailing-list.send') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Email</button>
        </form>
    </div>
@endsection
