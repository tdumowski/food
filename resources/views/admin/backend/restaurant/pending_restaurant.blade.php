@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pending Restaurants</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pending Restaurants</li>
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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($restaurants as $key => $restaurant)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ (!empty($restaurant->photo)) ? url('upload/client_images/' . $restaurant->photo) : url('upload/no_user.png') }}" 
                                        alt="" style="width: 50px; height:50px;"></td>
                                    <td>{{ $restaurant->name }}</td>
                                    <td>{{ $restaurant->email }}</td>
                                    <td>{{ $restaurant->phone }}</td>
                                    <td>
                                        @if ( $restaurant->status == 1)
                                            <span class="text-success"><b>Active</b></span>
                                        @else
                                            <span class="text-danger"><b>Inactive</b></span>
                                        @endif</td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $restaurant->id }}" class="toggle-class" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $restaurant->status ? 'checked' : '' }}>
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

<script type="text/javascript">

    $(document).ready(function() {
        $('#datatable').DataTable({
            drawCallback: function() {
                $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
            }
        });
    });

    $(function() {
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0; 
            var product_id = $(this).data('id'); 
            
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/changeStatus',
                data: {'status': status, 'product_id': product_id},
                success: function(data){
                // console.log(data.success)

                    // Start Message 

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success', 
                    showConfirmButton: false,
                    timer: 3000 
                })
                if ($.isEmptyObject(data.error)) {
                    Toast.fire({
                        type: 'success',
                        title: data.success, 
                    })
                }else{
                Toast.fire({
                        type: 'error',
                        title: data.error, 
                        })
                    }
                }
            });
        })
    })
</script>

@endsection