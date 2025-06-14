<tbody>
    @foreach ($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->category_name }}</td>
            <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <button class="btn btn-warning" wire:click="edit({{ $category->id }})">Edit</button>
                <button class="btn btn-danger" wire:click="delete({{ $category->id }})">Delete</button>
            </td>
        </tr>
    @endforeach
</tbody>
