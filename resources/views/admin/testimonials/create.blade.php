@extends('adminlte::page')

@section('title', 'Create Testimonial')

@section('content_header')
    <h1>Create New Testimonial</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus mr-2"></i>Add Testimonial
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                   value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="customer_position" class="form-label">Customer Position</label>
                            <input type="text" class="form-control" id="customer_position" name="customer_position"
                                   value="{{ old('customer_position') }}" placeholder="e.g., CEO, Marketing Manager">
                            @error('customer_position')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="testimony" class="form-label">Testimony <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="testimony" name="testimony" rows="6"
                                      placeholder="Enter the customer's testimonial..." required>{{ old('testimony') }}</textarea>
                            @error('testimony')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active"
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Active (Show this testimonial on the website)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                            <small class="form-text text-muted">Upload JPG, PNG, or GIF (max 2MB, square images work best)</small>
                            @error('profile_picture')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <div id="image-preview" class="d-none">
                                <h6>Preview:</h6>
                                <img id="preview-img" src="" alt="Preview" class="img-fluid rounded-circle" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Testimonial
                    </button>
                    <a href="{{ route('admin.testimonials') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Back to Testimonials
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        :root {
            --primary-color: #155e60;
            --secondary-color: #f7efd3;
        }

        .custom-control-label {
            font-weight: normal;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .btn-primary:hover {
            background-color: #0e4a4d !important;
            border-color: #0e4a4d !important;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), #0e4a4d) !important;
            color: white !important;
            border-bottom: none !important;
        }

        .card-header .card-title {
            color: white !important;
            margin: 0;
        }

        .card-header .card-title i {
            color: var(--secondary-color) !important;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(21, 94, 96, 0.25) !important;
        }

        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Image preview
        $('#profile_picture').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result);
                    $('#image-preview').removeClass('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                $('#image-preview').addClass('d-none');
            }
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
