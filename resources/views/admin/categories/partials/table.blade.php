<table class="table table-borderless">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Products</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ Str::limit($category->description, 50) }}</td>
                <td>{{ $category->products_count }}</td>
                <td>
                    @if($category->image)
                        @if(str_starts_with($category->image, 'http'))
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                        @else
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                        @endif
                    @else
                        <div class="text-muted small">No Image</div>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
