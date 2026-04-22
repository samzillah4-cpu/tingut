@extends('adminlte::page')

@section('title', 'Create Home Sale')

@section('content_header')
    <h1>Create Home Sale</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Create New Home Sale</h5>
                    <small class="text-muted">Fill in the details below to create a new home sale advertisement</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.home-sales.store') }}" method="POST" enctype="multipart/form-data" id="homeSaleForm">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sale_date_from">Sale Date From <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('sale_date_from') is-invalid @enderror" id="sale_date_from" name="sale_date_from" value="{{ old('sale_date_from') }}" required>
                            @error('sale_date_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sale_date_to">Sale Date To <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('sale_date_to') is-invalid @enderror" id="sale_date_to" name="sale_date_to" value="{{ old('sale_date_to') }}" required>
                            @error('sale_date_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="location">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g., Oslo" required>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Street address">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" placeholder="City">
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="images">Images</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                        <label class="custom-file-label" for="images">Choose files</label>
                    </div>
                    <small class="form-text text-muted">You can upload multiple images (max 2MB each)</small>
                    @error('images.*')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Feature this home sale (will be displayed prominently)
                        </label>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Available Items Section -->
                <div class="items-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Available Items</h4>
                        <button type="button" class="btn" style="background-color: var(--primary-color); color: white;" onclick="addItem()">
                            <i class="fas fa-plus mr-1"></i>Add Item
                        </button>
                    </div>

                    <p class="text-muted mb-3">Add items that will be available at this home sale. Each item can have an image, name, description, category, condition, and price.</p>

                    <div id="items-container">
                        <!-- Items will be added here dynamically -->
                    </div>

                    <div id="no-items-message" class="text-center py-4 bg-light rounded" style="display: none;">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No items added yet. Click "Add Item" to add items.</p>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn px-4" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-save me-2"></i>Create Home Sale
                    </button>
                    <a href="{{ route('admin.home-sales.index') }}" class="btn btn-outline-secondary ml-2">
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

        .item-card {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .item-card .item-image-preview {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            background: #e9ecef;
        }

        .item-card .image-upload-area {
            width: 100%;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #f8f9fa;
            transition: all 0.2s;
        }

        .item-card .image-upload-area:hover {
            border-color: var(--primary-color);
            background: rgba(26, 105, 105, 0.05);
        }

        .item-card .image-upload-area i {
            font-size: 2rem;
            color: #ccc;
        }

        .remove-item-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0.8;
        }

        .remove-item-btn:hover {
            opacity: 1;
        }

        .item-card {
            position: relative;
        }
    </style>
@stop

@section('js')
    <script>
        let itemCounter = 0;

        function addItem() {
            const container = document.getElementById('items-container');
            const noItemsMessage = document.getElementById('no-items-message');

            noItemsMessage.style.display = 'none';

            const itemHtml = `
                <div class="item-card" id="item-${itemCounter}">
                    <button type="button" class="remove-item-btn" onclick="removeItem(${itemCounter})">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="image-upload-area" onclick="document.getElementById('item-image-${itemCounter}').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" class="d-none" id="item-image-${itemCounter}" name="item_images[]" accept="image/*" onchange="previewItemImage(event, ${itemCounter})">
                            <input type="hidden" id="item-image-name-${itemCounter}" name="item_image_names[]">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Item Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="item_names[]" placeholder="Enter item name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price (NOK)</label>
                                        <input type="number" class="form-control" name="item_prices[]" step="0.01" min="0" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="item_categories[]">
                                            <option value="">Select category</option>
                                            <option value="Furniture">Furniture</option>
                                            <option value="Electronics">Electronics</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Books">Books</option>
                                            <option value="Toys">Toys</option>
                                            <option value="Kitchenware">Kitchenware</option>
                                            <option value="Garden">Garden</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Condition</label>
                                        <select class="form-control" name="item_conditions[]">
                                            <option value="">Select condition</option>
                                            <option value="New">New</option>
                                            <option value="Like New">Like New</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="item_descriptions[]" rows="2" placeholder="Describe the item"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', itemHtml);
            itemCounter++;
        }

        function removeItem(id) {
            const itemCard = document.getElementById(`item-${id}`);
            itemCard.remove();

            const container = document.getElementById('items-container');
            const noItemsMessage = document.getElementById('no-items-message');

            if (container.children.length === 0) {
                noItemsMessage.style.display = 'block';
            }
        }

        function previewItemImage(event, id) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadArea = event.target.parentElement;
                    uploadArea.innerHTML = `<img src="${e.target.result}" class="item-image-preview" alt="Item preview">`;
                    document.getElementById(`item-image-name-${id}`).value = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        // Initialize with one item
        document.addEventListener('DOMContentLoaded', function() {
            addItem();
        });

        // Update custom file input label
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files.length + ' file(s) selected';
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>
@stop
