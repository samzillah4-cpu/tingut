@extends('adminlte::page')

@section('title', 'View Blog Post')

@section('content_header')
    <h1>{{ $blog->title }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="img-fluid mb-3">
            @endif

            <p><strong>Status:</strong>
                @if($blog->is_published)
                    <span class="badge badge-success">Published</span>
                @else
                    <span class="badge badge-secondary">Draft</span>
                @endif
            </p>

            <p><strong>Published At:</strong> {{ $blog->published_at ? $blog->published_at->format('Y-m-d H:i') : 'Not set' }}</p>

            <div>
                <strong>Content:</strong>
                <div class="mt-2">{!! nl2br(e($blog->content)) !!}</div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@stop
