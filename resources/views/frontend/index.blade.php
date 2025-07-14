@extends('frontend.master')
@section('content')

<section class="section pt-5 pb-5 products-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Popular Restaurants</h2>
            <p>Top restaurants, cafes, pubs, and bars in Ludhiana, based on trends</p>
            <span class="line"></span>
        </div>
        <div class="row">

            @php
                $clients = \App\Models\Client::where('status', 1)
                    ->orderBy('name')
                    ->get();
            @endphp

            @foreach ($clients as $client)

            @php
                $menus = \App\Models\Menu::where('client_id', $client->id)
                    ->orderBy('name')
                    ->get();
                $menuNames = $menus->pluck('name')->implode(' • ');

                $coupon = \App\Models\Coupon::where('client_id', $client->id)
                    ->where('status', 1)
                    ->first();
            @endphp

                <div class="col-md-3">
                    <div class="item pb-3">
                        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                            <div class="list-card-image">
                                <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                                <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                                
                                @if ($coupon)
                                    <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                @endif

                                <a href="{{ route('restaurant.details', $client->id) }}">
                                <img src="{{ asset('upload/client_images/' . $client->photo) }}" class="img-fluid item-img" style="width: 300px; height: 200px;" 
                                    alt="{{ $client->name }}">
                                </a>
                            </div>
                            <div class="p-3 position-relative">
                                <div class="list-card-body">
                                    <h6 class="mb-1"><a href="{{ route('restaurant.details', $client->id) }}" class="text-black">{{ $client->name }}</a></h6>
                                    <p class="text-gray mb-3">{{ $menuNames }}</p>
                                    <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2">
                                        <i class="icofont-wall-clock"></i> 20–25 min</span></p>
                                </div>

                                @if ($coupon)
                                    <div class="list-card-badge">
                                        <span class="badge badge-success">OFFER</span> <small>{{ $coupon->discount }}% off | Use Coupon {{ $coupon->name }}</small>
                                    </div>
                                @else
                                    <div class="list-card-badge">
                                        <span class="badge badge-success">OFFER</span> <small><i>No discount coupon</i></small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>

@endsection