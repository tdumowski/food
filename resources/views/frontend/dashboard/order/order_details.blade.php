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
                            <h4 class="font-weight-bold mt-0 mb-4">Order details</h4>
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
                                                            <td>$ {{ $order->total_amount }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="50%">Status:</th>
                                                            <td><span class="badge bg-primary">{{ $order->status }}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row --> 

                            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-1">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-1">
                                                            <label>Image</label>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <label>Product</label>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <label>Restaurant</label>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <label>Product code</label>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <label>Quantity</label>
                                                        </td>
                                                        <td class="col-md-1">
                                                            <label>Price</label>
                                                        </td>
                                                    </tr>

                                                    @foreach($orderItems as $item)
                                                        <tr>
                                                            <td class="col-md-1">
                                                                <img src="{{ asset($item->product->image) }}" alt="" style="width:50px; height:50px">
                                                            </td>
                                                            <td class="col-md-2">
                                                                {{ $item->product->name }}
                                                            </td>
                                                            <td class="col-md-2">
                                                                {{ $item->client->name }}
                                                            </td>
                                                            <td class="col-md-1">
                                                                {{ $item->product->code }}
                                                            </td>
                                                            <td class="col-md-1">
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td class="col-md-1">
                                                                $ {{ $item->price }} <br> Total: <strong>$ {{ $item->price * $item->quantity }}</strong>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div>
                                                <h4>Total price: $ {{ $totalPrice }}</h4>
                                            </div>

                                        </div>
                                    </div>
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