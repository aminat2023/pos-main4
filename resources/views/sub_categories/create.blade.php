<div>
    <h2>Create Subcategory</h2>
    
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="createSubCategory">
        <div class="form-group">
            <label for="subcategory_name">Subcategory Name:</label>
            <input type="text" wire:model="subcategory_name" class="form-control" id="subcategory_name" required>
            @error('subcategory_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Select Category:</label>
            <select wire:model="category_id" class="form-control" id="category_id" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Subcategory</button>
    </form>

    <h3>Existing Subcategories</h3>
    <ul>
        @foreach ($subcategories as $subcategory)
            <li>{{ $subcategory->sub_category_name }} (Category: {{ $subcategory->category->category_name }})</li>
        @endforeach
    </ul>
</div>
