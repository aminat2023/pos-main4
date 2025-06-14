<div class="modal fade" id="editSection" wire:ignore.self data-backdrop="static">
    <div class="modal-dialog right-crud modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#008B8B">
                <h3 class="modal-title">Edit Section</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                
                    <div class="clearfix"></div> <!-- Clearfix for float -->

                    <div class="row">

                        <div class="col-12 mb-3"> <!-- Full-width layout -->
                            <div class="d-flex align-items-center"> <!-- Flexbox for alignment -->
                                <div class="flex-grow-1"> <!-- Allow this div to grow -->
                                    <div class="form-group mb-1"> <!-- Adjust margin -->
                                        <input type="text" class="form-control" wire:model.defer="section_name"
                                            placeholder="Section Name" required>
                                    </div>
                                </div>
                                <div class="form-group mb-0 mx-2"> <!-- Margin for spacing -->
                                    <label class="square-switch">
                                        <input type="checkbox" wire:model.defer="section_status">
                                        <span class="slider square"></span> <!-- Square switch -->
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" style="background-color: #008B8B;color:aliceblue" class="btn btn-block"
                            :disabled="$isSubmitting">Update Section</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
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
        height: 20px;
        /* Adjust height for square look */
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
        width: 20px;
        /* Width to fit the square */
        left: 0;
        /* Margin from left */
        bottom: 0;
        /* Margin from bottom */
        background-color: rgb(183, 190, 194);
        transition: 0.4s;
    }

    input:checked+.slider.square {
        background-color: #6885e6;
    }

    input:checked+.slider.square:before {
        transform: translateX(20px);
        /* Adjust for the width of the switch */
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
