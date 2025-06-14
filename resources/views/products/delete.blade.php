<td>
    <div class="btn-group">
        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editproduct{{ $product->id }}">
            <i class="fa fa-edit"></i> Edit
        </a>
        <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                onclick="return confirm('Are you sure you want to delete this product?');">
                <i class="fa fa-trash"></i> Delete
            </button>
        </form>
    </div>
</td>
