@php use App\Models\Category; @endphp
@extends('layouts.backend')
@section('title', 'Categories')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <div class="container-fluid px-4">
        @include('layouts.partials.flash_message')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Category Management</h1>
            @can('create', Category::class)
                <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New
                    Category</a>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table me-1"></i> Category Overview</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Posts Count</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>
                                @if($category->trashed())
                                    <span class="badge bg-warning">Trashed</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if(!$category->trashed())
                                        <!-- Alleen tonen als de categorie NIET verwijderd is -->
                                        @can('update', $category)
                                            <a href="{{ route('categories.edit', $category) }}"
                                               class="btn btn-sm btn-info"
                                               title="Edit Category">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>
                                        @endcan
                                    @endif
                                    @if($category->trashed())
                                        @can('restore', $category)
                                            <form method="POST"
                                                  action="{{ route('categories.restore', $category->id) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm btn-success"
                                                        title="Restore Category">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('forceDelete', $category)
                                            <form method="POST"
                                                  action="{{ route('categories.forceDelete', $category->id) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Permanently Delete Category"
                                                        onclick="return confirm('Are you sure you want to permanently delete this category?');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @else
                                        @can('delete', $category)
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-warning"
                                                        title="Move to Trash"
                                                        onclick="return confirm('Are you sure you want to move this category to the trash?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
