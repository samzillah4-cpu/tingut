@extends('adminlte::page')

@section('title', 'Testimonials Management')

@section('content_header')
    <h1>Testimonials Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-comments mr-2"></i>All Testimonials
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Testimonial
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="60">Order</th>
                                <th width="80">Image</th>
                                <th>Customer Name</th>
                                <th>Position</th>
                                <th>Testimony</th>
                                <th width="100">Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="testimonials-table">
                            @foreach($testimonials as $testimonial)
                                <tr data-id="{{ $testimonial->id }}">
                                    <td>
                                        <i class="fas fa-grip-vertical handle" style="cursor: move; color: #6c757d;"></i>
                                        <span class="order-number ml-2">{{ $testimonial->order }}</span>
                                    </td>
                                    <td>
                                        @if($testimonial->profile_picture)
                                            <img src="{{ asset('storage/' . $testimonial->profile_picture) }}"
                                                 alt="{{ $testimonial->customer_name }}"
                                                 class="rounded-circle"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $testimonial->customer_name }}</td>
                                    <td>{{ $testimonial->customer_position ?: '-' }}</td>
                                    <td>{{ Str::limit($testimonial->testimony, 100) }}</td>
                                    <td>
                                        @if($testimonial->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.testimonials.delete', $testimonial) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h4>No testimonials yet</h4>
                    <p class="text-muted">Start building trust by adding customer testimonials.</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Testimonial
                    </a>
                </div>
            @endif
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

        .handle {
            cursor: move;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--primary-color);
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-secondary {
            background-color: #6c757d;
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
    </style>
@stop

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Make table rows sortable
        $("#testimonials-table").sortable({
            handle: '.handle',
            update: function(event, ui) {
                var order = [];
                $('#testimonials-table tr').each(function(index) {
                    var id = $(this).data('id');
                    if (id) {
                        order.push({
                            id: id,
                            order: index + 1
                        });
                        $(this).find('.order-number').text(index + 1);
                    }
                });

                // Send order update to server
                $.ajax({
                    url: '{{ route("admin.testimonials.order") }}',
                    method: 'POST',
                    data: {
                        testimonials: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Optional: Show success message
                        }
                    },
                    error: function() {
                        alert('Error updating order. Please try again.');
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@stop
