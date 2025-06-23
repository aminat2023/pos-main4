<div class="modal fade" id="addUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('users.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-teal text-white">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="form-group"><label>Confirm Password</label><input type="password" name="confirm_password" class="form-control" required></div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="is_admin" class="form-control">
                        <option value="1">Admin</option>
                        <option value="0">Cashier</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block">Save</button>
            </div>
        </form>
    </div>
</div>
