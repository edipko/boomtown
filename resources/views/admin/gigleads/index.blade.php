@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Manage Gig Leads</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Notes</th>
                <th>Followed Up</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gigLeads as $lead)
                <tr>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>{{ $lead->telephone }}</td>
                    <td>{{ $lead->notes }}</td>
                    <td>{{ $lead->followed_up ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('gigleads.edit', $lead) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('gigleads.destroy', $lead) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
