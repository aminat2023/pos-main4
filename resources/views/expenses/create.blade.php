@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
        <div class="card-header text-white text-center" style="background-color: teal;">
            <h4 class="mb-0">Register Expense</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="category">Category</label>
                    <div class="input-group" style="width: 100%;">
                        <select style="min-width: 200px;" name="category" id="category-select" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="Utility">Utility</option>
                            <option value="Transport">Transport</option>
                            <option value="Food">Food</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addCategoryModal">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                

                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (₦)</label>
                    <input type="number" name="amount" id="amount" class="form-control" min="0.01" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="newCategoryInput" class="form-control" placeholder="Enter new category name">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success btn-sm" id="saveCategoryBtn">Add</button>
        </div>
      </div>
    </div>
  </div>
  
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('saveCategoryBtn').addEventListener('click', function () {
            const input = document.getElementById('newCategoryInput');
            const newCategory = input.value.trim();

            if (newCategory !== '') {
                const select = document.getElementById('category-select');

                // Create new option element
                const option = document.createElement('option');
                option.value = newCategory;
                option.textContent = newCategory;
                option.selected = true;

                // Append to dropdown
                select.appendChild(option);

                // Clear input and close modal
                input.value = '';
                $('#addCategoryModal').modal('hide');
            }
        });
    });
</script>


@endsection
