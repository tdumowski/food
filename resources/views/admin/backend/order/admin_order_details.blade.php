@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Order details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
            <div class="col">
                <div class="card">
                    <div class="card-header"><h4>Shipping details</h4></div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered border-primary mb-0">

                                <tbody>
                                    <tr>
                                        <th width="50%">Shipping name:</th>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Phone:</th>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Email:</th>
                                        <td>{{ $order->email }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Address:</th>
                                        <td>{{ $order->address }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Order date:</th>
                                        <td>{{ $order->order_date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Order details - <span class="text-danger">Invoice: {{ $order->invoice_number }}</span>
                        </h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered border-primary mb-0">

                                <tbody>
                                    <tr>
                                        <th width="50%">Name:</th>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Phone:</th>
                                        <td>{{ $order->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Email:</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Address:</th>
                                        <td>{{ $order->user->address }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Payment type:</th>
                                        <td>{{ $order->payment_type }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Transaction Id:</th>
                                        <td>{{ $order->transaction_id }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Invoice:</th>
                                        <td>{{ $order->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Amount:</th>
                                        <td>${{ $order->total_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th width="50%">Status:</th>
                                        <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <th width="50%"></th>
                                        <td>
                                            @if($order->status == "PENDING")
                                                <a href="" class="btn btn-block btn-success">Confirm order</a>
                                            @elseif($order->status == "CONFIRM")
                                                <a href="" class="btn btn-block btn-success">Processing order</a>
                                            @elseif($order->status == "PROCESSING")
                                                <a href="" class="btn btn-block btn-success">Delivered order</a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row --> 
    </div> <!-- container-fluid -->
</div>

@endsection