@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Roles</h3>
            @can('create roles')
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="ti ti-plus fs-6"></i> 
                {{-- Create Role --}}
            </a>
            @endcan
        </div>

        <div class="card-body">
            @if($roles->isEmpty())
                <p>No roles found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        {{-- Display permissions comma separated --}}
                                        {{ $role->permissions->pluck('name')->implode(', ') }}
                                    </td>
                                    <td>{{ $role->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            {{-- Button group for actions --}}
                                            <div class="btn-group" role="group" aria-label="Actions">
                                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @can('edit roles')
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                @endcan
                                                @can('delete roles')
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
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
