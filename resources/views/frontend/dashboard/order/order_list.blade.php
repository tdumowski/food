@extends('frontend.dashboard.dashboard')
@section('dashboard')

@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
        <div class="row">

            @include('frontend.dashboard.sidebar')

            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <h4 class="font-weight-bold mt-0 mb-4">Orders list</h4>

                            <div class="bg-white card mb-4 order-list shadow-sm">
                                <div class="gold-members p-4">

                                    <table class="table table-bordered dt-responsive  nowrap w-100">
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
                                                    @php
                                                        $statusColor = ($order->status == "DELIVERED") ? "success" : "primary";
                                                    @endphp
                                                    <td><span class="badge bg-{{ $statusColor }}">{{ $order->status }}</span></td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.order_details', $order->id) }}" class="btn-small d-block text-info mr-3"><i class="fas fa-eye mr-1"></i>View</a>
                                                        <a href="{{ route('admin.order_details', $order->id) }}" class="btn-small d-block text-primary mr-3"><i class="fas fa-download mr-1"></i>Invoice</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection