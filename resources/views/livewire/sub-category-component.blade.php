<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 xs-12">
            <div class="card">
                <div class="card-header" style="background-color: #008B8B">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="#addCategory" class="btn btn-primary" data-toggle="modal">
                                <i class="fa fa-plus-circle"></i> Add Category
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('sub_categories.table') <!-- Include the table for displaying categories -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include the modal for creating a new category -->
    @include('sub_categories.create')
</div>

