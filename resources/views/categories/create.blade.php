<!-- categories/create.blade.php -->

<div wire:ignore.self class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="store">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="addCategoryLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="$set('category_name', '')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Section Select -->
                    <div class="form-group">
                        <label for="section_id">Section</label>
                        <select id="section_id" wire:model.defer="section_id" class="form-control" required>
                            <option value="">-- Select Section --</option>
                            @foreach($sections ?? [] as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                        @error('section_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" id="category_name" wire:model.defer="category_name" class="form-control" placeholder="Enter category name" required>
                        @error('category_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Discount -->
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" id="discount" wire:model.defer="discount" class="form-control" min="0" step="0.01" placeholder="0.00">
                        @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" wire:model.defer="description" class="form-control" placeholder="Enter description" rows="3"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group form-check">
                        <input type="checkbox" id="category_status" wire:model.defer="category_status" class="form-check-input">
                        <label for="category_status" class="form-check-label">Active</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$set('category_name', '')">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-header {
        border-bottom: 2px solid #008B8B;
    }

    .modal-body {
        padding: 1rem;
    }

    .form-group {
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #21963;
        box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
    }

    .square-switch {
        position: relative;
        display: inline-block;
        width: 40px; 
        height: 20px; /* Adjust height for square look */
    }

    .square-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider.square {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
    }

    .slider.square:before {
        position: absolute;
        content: "";
        height: 20px; 
        width: 20px; /* Width to fit the square */
        left: 0; /* Margin from left */
        bottom: 0; /* Margin from bottom */
        background-color: rgb(183, 190, 194);
        transition: 0.4s;
    }

    input:checked + .slider.square {
        background-color: #6885e6;
    }

    input:checked + .slider.square:before {
        transform: translateX(20px); /* Adjust for the width of the switch */
    }

    .btn-primary {
        background-color: #2196F3;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #1976D2;
    }

    .btn-danger {
        background-color: #f44336;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-danger:hover {
        background-color: #d32f2f;
    }

    .btn-success {
        background-color: #4CAF50;
        border: none;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-success:hover {
        background-color: #45a049;
    }
</style>
