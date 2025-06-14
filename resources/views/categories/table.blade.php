<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="col-md-4 col-sm-4">
        @if (count($checked) > 1)
            <a href="#" class="btn btn-outline btn-sm" wire:click="confirmBulkDelete">
                ( {{ count($checked) }} Row Selected to be <b>Deleted</b>)
            </a>
        @endif
    </div>

    <table class="table" width="100%">
        <thead>
            <tr>
                <th><input class="h-5 w-5" type="checkbox" wire:model="selectAll"></th>
                <th>Category Name</th>
                <th>Status</th>
                <th>Discount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td><input value="{{ $category->id }}" class="h-5 w-5" type="checkbox" wire:model="checked"></td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                    <td>{{ $category->discount ?? 'N/A' }}</td>
                    <td>{{ $category->description ?? 'N/A' }}</td>
                    <td>
                        <a href="#editCategory" wire:click.prevent="editCategory({{ $category->id }})" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#editCategoryModal">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @if (count($checked) < 2)
                        <a href="#" class="btn btn-outline-danger btn-sm" wire:click.prevent="ConfirmDelete({{ $category->id }}, '{{ $category->category_name }}')">
                            <i class="fa fa-trash"></i>
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true" style="@if($categoryId) display: block; @else display: none; @endif">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background:#008B8B">
                    <h3 class="modal-title">Edit Category</h3>
                    <button type="button" class="close text-white" wire:click="resetInputFields">&times;</button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateCategory">
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model.defer="category_name" placeholder="Category Name" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" wire:model.defer="discount" placeholder="Discount" min="0">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" wire:model.defer="description" placeholder="Description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="square-switch">
                                <input type="checkbox" wire:model.defer="category_status">
                                <span class="slider square"></span>
                            </label>
                            <span>Status</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                            <button type="button" class="btn btn-danger" wire:click="resetInputFields">Close</button>
                        </div>
                    </form>
                </div>
                {{-- @include('categories.edit') --}}
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('Swal:DeletedRecord', event => {
        Swal.fire({
            title: event.detail.title,
            text: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('deleteCategory', event.detail.id);
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                });
            }
        });
    });
</script>
