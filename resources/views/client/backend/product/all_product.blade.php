@extends('client.client_dashboard')
@section('client')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Products</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('add.product') }}" class="btn btn-primary waves-effect waves-light">Add product</a>
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
                                    <th>Menu</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
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
                                    <td>{{ $product->menu_id }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->discount_price }}</td>
                                    <td>
                                        @if ( $product->status == 1)
                                            {{-- <span class="badge bg-success">Active</span> --}}
                                            <span class="text-success"><b>Active</b></span>
                                        @else
                                            <span class="text-danger"><b>Inactive</b></span>
                                            {{-- <span class="badge bg-danger">Inactive</span> --}}
                                        @endif</td>
                                    <td>
                                        <a href="{{ route('edit.menu', $product->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a href="{{ route('delete.menu', $product->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
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