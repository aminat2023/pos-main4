<tbody>
    @foreach ($sections as $section)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $section->section_name }}</td>
            <td>{{ $section->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <button class="btn btn-warning" wire:click="edit({{ $section->id }})">Edit</button>
                <button class="btn btn-danger" wire:click="delete({{ $section->id }})">Delete</button>
            </td>
        </tr>
    @endforeach
</tbody>
