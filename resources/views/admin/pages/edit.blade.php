@extends('adminlte::page')

@section('title', 'Edit Page: ' . $page->title)

@section('content_header')
    <h1>Edit Page: {{ $page->title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>Edit Page Content
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Page Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ old('title', $page->title) }}" required>
                            @error('title')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">URL Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                   value="{{ old('slug', $page->slug) }}" required>
                            <small class="form-text text-muted">URL will be: /pages/your-slug</small>
                            @error('slug')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Page Content</label>
                            <textarea class="form-control" id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
                            <small class="form-text text-muted">You can use HTML tags for formatting</small>
                            @error('content')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Page is active and visible to visitors</label>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.website.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Website Management
                            </a>
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Page
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Auto-generate slug from title
    $('#title').on('input', function() {
        var title = $(this).val();
        var slug = title.toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        $('#slug').val(slug);
    });
});
</script>
@stop
