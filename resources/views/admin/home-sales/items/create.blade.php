@extends('adminlte::page')

@section('title', 'Add Item to Home Sale')

@section('content_header')
    <h1>Add Item to: {{ $homeSale->title }}</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Add New Item</h5>
                    <small class="text-muted">Add an item to this home sale</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.home-sales.items.store', $homeSale) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Item Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">NOK</span>
                                </div>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Describe the item">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">Select a category</option>
                                <option value="Furniture" {{ old('category') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                <option value="Electronics" {{ old('category') === 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Clothing" {{ old('category') === 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="Books" {{ old('category') === 'Books' ? 'selected' : '' }}>Books</option>
                                <option value="Toys" {{ old('category') === 'Toys' ? 'selected' : '' }}>Toys</option>
                                <option value="Kitchenware" {{ old('category') === 'Kitchenware' ? 'selected' : '' }}>Kitchenware</option>
                                <option value="Garden" {{ old('category') === 'Garden' ? 'selected' : '' }}>Garden</option>
                                <option value="Sports" {{ old('category') === 'Sports' ? 'selected' : '' }}>Sports</option>
                                <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <select class="form-control @error('condition') is-invalid @enderror" id="condition" name="condition">
                                <option value="">Select condition</option>
                                <option value="New" {{ old('condition') === 'New' ? 'selected' : '' }}>New</option>
                                <option value="Like New" {{ old('condition') === 'Like New' ? 'selected' : '' }}>Like New</option>
                                <option value="Good" {{ old('condition') === 'Good' ? 'selected' : '' }}>Good</option>
                                <option value="Fair" {{ old('condition') === 'Fair' ? 'selected' : '' }}>Fair</option>
                                <option value="Poor" {{ old('condition') === 'Poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                            @error('condition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Item Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <label class="custom-file-label" for="image">Choose file</label>
                    </div>
                    <small class="form-text text-muted">Upload an image of the item (max 2MB)</small>
                    @error('image')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn px-4" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-save me-2"></i>Add Item
                    </button>
                    <a href="{{ route('admin.home-sales.show', $homeSale) }}" class="btn btn-outline-secondary ml-2">
                        <i class="fas fa-times me-2"></i>Cancel
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
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .form-control:focus, .custom-file-input:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }
    </style>
@stop

@section('js')
    <script>
        // Update custom file input label
        document.getElementById('image').addEventListener('change', function(e) {
            var fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>
@stop
