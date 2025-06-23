<div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header bg-teal text-white">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Name</label><input type="text" name="name" value="{{ $user->name }}" class="form-control"></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ $user->email }}" class="form-control"></div>
                <div class="form-group"><label>Phone</label><input type="text" name="phone" value="{{ $user->phone }}" class="form-control"></div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="is_admin" class="form-control">
                        <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Cashier</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block">Update</button>
            </div>
        </form>
    </div>
</div>
