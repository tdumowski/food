@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Confirmed orders</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
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
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->invoice_number }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td>{{ $order->payment_type }}</td>
                                    <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.order_details', $order->id) }}" class="btn btn-info waves-effect waves-light"><i class="fas fa-eye"></i></a>
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