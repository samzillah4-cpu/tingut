@extends('adminlte::page')

@section('title', 'Create Blog Post')

@section('content_header')
    <h1>Create Blog Post</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Create New Blog Post</h5>
                    <small class="text-muted">Write and publish engaging blog content</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Blog Title</label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter an engaging title for your blog post" style="border-radius: 8px; padding: 12px 16px;">
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Content</label>
                            <textarea class="form-control border-0 bg-light" id="content" name="content" required placeholder="Write your blog content here..." style="border-radius: 8px; padding: 12px 16px;">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Featured Image</label>
                            <input type="file" class="form-control border-0 bg-light" id="image" name="image" accept="image/*" style="border-radius: 8px;">
                            <small class="form-text text-muted mt-1">Upload JPG, PNG, or GIF (max 2MB)</small>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Publishing Options</label>
                            <div class="card border-0 bg-light" style="border-radius: 8px;">
                                <div class="card-body p-3">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="is_published">
                                            Publish immediately
                                        </label>
                                        <small class="form-text text-muted d-block">Make this blog post visible to visitors right away</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="published_at" class="form-label fw-semibold">Schedule Publication</label>
                                        <input type="datetime-local" class="form-control border-0 bg-white" id="published_at" name="published_at" value="{{ old('published_at') }}" style="border-radius: 6px;">
                                        <small class="form-text text-muted">Leave empty to publish immediately when saved</small>
                                        @error('published_at')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="card border-0 bg-info bg-opacity-10" style="border-radius: 8px;">
                                <div class="card-body p-3">
                                    <h6 class="card-title text-info mb-2">
                                        <i class="fas fa-lightbulb me-2"></i>Tips for Great Blog Posts
                                    </h6>
                                    <ul class="list-unstyled small mb-0 text-muted">
                                        <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Use engaging titles</li>
                                        <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Add relevant images</li>
                                        <li class="mb-1"><i class="fas fa-check text-success me-1"></i> Write clear, concise content</li>
                                        <li class="mb-0"><i class="fas fa-check text-success me-1"></i> Schedule for best timing</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Fill in all required fields to create your blog post
                            </div>
                            <div>
                                <button type="submit" class="btn px-4 me-2" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                                    <i class="fas fa-save me-2"></i>Create Blog Post
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Blog Posts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
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

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .card.border-0 {
            box-shadow: none;
        }

        .bg-info.bg-opacity-10 {
            background-color: rgba(23, 162, 184, 0.1) !important;
        }

        .cke_chrome {
            border-radius: 8px !important;
            border: 1px solid #dee2e6 !important;
        }

        .cke_top {
            background: linear-gradient(135deg, var(--primary-color), #0e4a4d) !important;
            border-radius: 8px 8px 0 0 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .cke_toolgroup {
            border: none !important;
            background: transparent !important;
        }

        .cke_button {
            border: none !important;
            background: transparent !important;
        }

        .cke_button:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .cke_button_on {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Initialize CKEditor
        CKEDITOR.replace('content', {
            height: 2000,
            toolbar: [
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                '/',
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                '/',
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                { name: 'others', items: ['-'] },
                { name: 'about', items: ['About'] }
            ],
            removePlugins: 'elementspath',
            resize_enabled: true,
            extraPlugins: 'autogrow',
            autoGrow_minHeight: 300,
            autoGrow_maxHeight: 600,
            autoGrow_bottomSpace: 50,
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}'
        });

        // Form validation
        $('form').on('submit', function(e) {
            var isValid = true;
            $(this).find('input[required], textarea[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
</script>
@stop
