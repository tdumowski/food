@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Import permission</h4>

                    <div class="page-title-right">
                        <a href="{{ route('export.excel.permission') }}" class="btn btn-danger waves-effect waves-light">Export</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body p-4">
                        <form id="myForm" action="{{ route('store.permission') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label" >XLSX file import</label>
                                            <input class="form-control" name="import_file" type="file" id="example-text-input">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Upload</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    <!-- end card body -->
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>

@endsection