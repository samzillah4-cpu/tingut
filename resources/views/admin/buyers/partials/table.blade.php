<table class="table table-borderless">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Location</th>
            <th>Exchanges Count</th>
            <th>Joined</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buyers as $buyer)
            <tr>
                <td>{{ $buyer->id }}</td>
                <td>{{ $buyer->name }}</td>
                <td>{{ $buyer->email }}</td>
                <td>{{ $buyer->location ?: 'Not specified' }}</td>
                <td>{{ ($buyer->proposed_exchanges_count ?? 0) + ($buyer->received_exchanges_count ?? 0) }}</td>
                <td>{{ $buyer->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.buyers.show', $buyer) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.buyers.edit', $buyer) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.buyers.login-as', $buyer) }}" class="btn btn-outline-success btn-sm" style="border-radius: 0;" onclick="return confirm('Are you sure you want to login as this buyer?')">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                        <form action="{{ route('admin.buyers.destroy', $buyer) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this buyer?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
