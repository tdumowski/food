@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Categories</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.category') }}" class="btn btn-primary waves-effect waves-light">Add Category</a>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><img src={{ asset($category->image) }} alt="" style="width: 50px; height:50px;"></td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('category.edit'))
                                            <a href="{{ route('edit.category', $category->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('category.delete'))
                                            <a href="{{ route('delete.category', $category->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row --> 
    </div> <!-- container-fluid -->
</div>

@endsection