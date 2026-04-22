@extends('adminlte::page')

@section('title', 'Blog Posts')

@section('content_header')
    <h1>Blog Posts</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-blog text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Blog Posts Management</h5>
                        <small class="text-muted">{{ $blogs->total() }} total blog posts</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.blogs.create') }}" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Blog Post
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Published At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>{{ Str::limit($blog->title, 50) }}</td>
                                <td>
                                    @if($blog->is_published)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $blog->published_at ? $blog->published_at->format('M d, Y H:i') : 'Not set' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this blog post?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-blog fa-3x mb-3"></i>
                                        <p>No blog posts found.</p>
                                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Create First Blog Post
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} blog posts
                </div>
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .table th {
            background-color: #217372;
            border-top: none;
            font-weight: 600;
            color: white;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .badge {
            font-size: 0.75rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .card-footer {
            border-radius: 0 0 12px 12px;
        }

        .btn-group .btn {
            border-color: #dee2e6 !important;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@stop
