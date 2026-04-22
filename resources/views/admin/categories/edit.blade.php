@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit Category</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Category</h5>
                            <small class="text-muted">Update category: {{ $category->name }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control border-0 bg-light" value="{{ old('name', $category->name) }}" required style="border-radius: 8px; padding: 12px;">
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="description" class="form-control border-0 bg-light" rows="3" style="border-radius: 8px; padding: 12px;">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Category Image</label>
                            <input type="file" name="image" id="image" class="form-control border-0 bg-light" accept="image/*" style="border-radius: 8px; padding: 12px;">
                            @if($category->image)
                                <div class="mt-3 p-3 border rounded" style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center">
                                        @if(str_starts_with($category->image, 'http'))
                                            <img src="{{ $category->image }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                        @else
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                        @endif
                                        <div>
                                            <small class="text-muted d-block">Current Image</small>
                                            <small class="text-muted">Leave empty to keep current image</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-1">
                                <i class="fas fa-info-circle me-1"></i>Upload a representative image for this category (optional)
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn px-4" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                                <i class="fas fa-save me-2"></i>Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
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

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }
    </style>
@stop
