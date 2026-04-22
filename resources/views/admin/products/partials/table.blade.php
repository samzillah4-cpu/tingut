<table class="table table-borderless">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User</th>
            <th>Category</th>
            <th>Type</th>
            <th>Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ Str::limit($product->title, 30) }}</td>
                <td>{{ $product->user->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <span class="badge badge-info">
                        {{ ucfirst($product->listing_type ?? 'sale') }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </td>
                <td>{{ count($product->images ?? []) }} images</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
