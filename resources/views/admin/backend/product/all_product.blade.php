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
                    <h4 class="mb-sm-0 font-size-18">All Products</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light">Add product</a>
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Restaurant</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src={{ asset($product->image) }} alt="" style="width: 70px; height:40px;"></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->client->name }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        @if (is_null($product->discount_price))
                                            <span class="badge bg-danger">No Discount</span>
                                        @else
                                            @php
                                                $discount = $product->price - $product->discount_price;
                                                $discountPercentage = ($discount / $product->price) * 100;
                                            @endphp
                                            <span class="badge bg-success">{{ round($discountPercentage) }}%</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if ( $product->status == 1)
                                            {{-- <span class="badge bg-success">Active</span> --}}
                                            <span class="text-success"><b>Active</b></span>
                                        @else
                                            <span class="text-danger"><b>Inactive</b></span>
                                            {{-- <span class="badge bg-danger">Inactive</span> --}}
                                        @endif</td>
                                    <td>
                                        <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info waves-effect waves-light"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{ route('delete.product', $product->id) }}" class="btn btn-danger waves-effect waves-light" id="delete"><i class="fas fa-trash"></i></a>
                                        <input type="checkbox" data-id="{{ $product->id }}" class="toggle-class" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $product->status ? 'checked' : '' }}>
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