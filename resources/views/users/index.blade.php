@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Card --}}
        <div class="card">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h3 class="card-title mb-0">Users</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus fs-6"></i> {{-- Plus icon --}}
                </a>
            </div>

            <div class="card-body">
                @if ($users->isEmpty())
                    <p>No users found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles->isNotEmpty())
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-secondary">{{ $role->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No roles</span>
                                            @endif
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info"
                                                    title="View">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
