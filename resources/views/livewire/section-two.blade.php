<div class="container-fluid">
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="#addSection" class="btn btn-primary" data-toggle="modal">
                               <i class="fa fa-plus-circle"></i> Add Section
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('section_twos.table')
                </div>
            </div>
        </div>
    </div>
    @include('section_twos.create')
</div>

