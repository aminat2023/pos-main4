<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Discount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->discount }}</td>
                    <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
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
    </table> --}}

    <!-- Edit Category Modal -->
    <div class="modal fade @if($categoryId) show @endif" style="@if($categoryId) display: block; @else display: none; @endif" tabindex="-1" role="dialog" aria-hidden="{{ $categoryId ? 'false' : 'true' }}">
        <div class="modal-dialog right-crud modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background:#008B8B">
                    <h3 class="modal-title">Edit Category</h3>
                    <button type="button" class="close text-white" wire:click="resetInputFields">&times;</button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateCategory" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="form-group mb-1">
                                            <input type="text" class="form-control" wire:model.defer="category_name"
                                                placeholder="Category Name" required>
                                        </div>
                                        <div class="form-group mb-1">
                                            <input type="number" class="form-control" wire:model.defer="discount"
                                                placeholder="Discount" min="0">
                                        </div>
                                        <div class="form-group mb-1">
                                            <textarea class="form-control" wire:model.defer="description"
                                                placeholder="Description" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 mx-2">
                                        <label class="square-switch">
                                            <input type="checkbox" wire:model.defer="category_status">
                                            <span class="slider square"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" style="background-color: #008B8B;color:aliceblue" class="btn btn-block">Update Category</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-block" wire:click="resetInputFields">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
