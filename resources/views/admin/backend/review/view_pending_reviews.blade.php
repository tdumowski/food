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
                    <h4 class="mb-sm-0 font-size-18">Pending Reviews</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pending Reviews</li>
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
                                    <th>User</th>
                                    <th>Restaurant</th>
                                    <th>Comment</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reviews as $key => $review)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $review->user->name }}</td>
                                    <td>{{ $review->client->name }}</td>
                                    <td>{{ Str::limit($review->comment, 50, '...') }}</td>
                                    <td>
                                        @for ($i = 1; $i <=5; $i++)
                                            <i class="bx bxs-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                    <td>
                                        @if ( $review->status == 1)
                                            <span class="text-success"><b>Approved</b></span>
                                        @else
                                            <span class="text-danger"><b>Pending</b></span>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="checkbox" data-id="{{ $review->id }}" class="toggle-class" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Approved" data-off="pending" {{ $review->status ? 'checked' : '' }}>
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
            var review_id = $(this).data('id'); 
            
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/reviewChangeStatus',
                data: {'status': status, 'review_id': review_id},
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