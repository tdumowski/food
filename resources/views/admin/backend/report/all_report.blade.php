@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Admin reports</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="bg-light-subtle p-3">
                            <div class="row">
                                <div class="col-sm-4">
                                    <form id="myForm" action="{{ route('admin.search.bydate') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <h5>Search by date</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="example-text-input" class="form-label">Date</label>
                                                        <input class="form-control" name="date" type="date" id="example-text-input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-sm-4">
                                    <form id="myForm" action="{{ route('admin.search.bymonth') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <h5>Search by month</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="example-text-input" class="form-label">Month</label>
                                                        <select name="month_name" class="form-select">
                                                            <option value="" disabled selected hidden>Select month</option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>

                                                        <label for="example-text-input" class="form-label">Year</label>
                                                        <select name="year_name" class="form-select">
                                                            <option value="" disabled selected hidden>Select year</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-sm-4">
                                    <form id="myForm" action="{{ route('admin.search.byyear') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <h5>Search by year</h5>
                                                    <div class="form-group mb-3">
                                                        <label for="example-text-input" class="form-label">Year</label>
                                                        <select name="year" class="form-select">
                                                            <option value="" disabled selected hidden>Select year</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row --> 

    </div> <!-- container-fluid -->
</div>

@endsection