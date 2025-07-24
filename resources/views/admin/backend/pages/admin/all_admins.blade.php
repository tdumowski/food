@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Admins</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.admin') }}" class="btn btn-primary waves-effect waves-light">Add Admin</a>
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
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($admins as $key => $admin)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ (!empty($admin->photo)) ? url('upload/admin_images/' . $admin->photo) : url('upload/no_user.png') }}" 
                                        alt="" class="img-fluid rounded-circle d-block" style="width: 30px; height: 30px;"></td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->mail }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            <span class="badge bg-success">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('edit.category', $category->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a href="{{ route('delete.category', $category->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a> --}}
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