@extends('frontend.dashboard.dashboard')
@section('dashboard')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

@php
    use Carbon\Carbon;

    $menuNames = $menus->pluck('name')->implode(' • ');

    $coupon = \App\Models\Coupon::where('client_id', $client->id)
        ->where('status', 1)
        ->whereDate('validity', '>=', Carbon::today()->format('Y-m-d'))
        ->first();

    $popularProducts = \App\Models\Product::where('client_id', $client->id)
        ->where('status', 1)
        ->where('most_popular', 1)
        ->orderBy('name')
        ->limit(5)
        ->get();

    $bestsellerProducts = \App\Models\Product::where('client_id', $client->id)
        ->where('status', 1)
        ->where('best_seller', 1)
        ->orderBy('name')
        ->limit(5)
        ->get();
@endphp


<section class="restaurant-detailed-banner">
    <div class="text-center">
    <img class="img-fluid cover" src="{{ asset('upload/client_images/' . $client->cover_image ) }}">
    </div>
    <div class="restaurant-detailed-header">
    <div class="container">
        <div class="row d-flex align-items-end">
            <div class="col-md-8">
                <div class="restaurant-detailed-header-left">
                <img class="img-fluid mr-3 float-left" alt="osahan" src="{{ asset('upload/client_images/' . $client->photo ) }}">
                <h2 class="text-white">{{ $client->name }}</h2>
                <p class="text-white mb-1"><i class="icofont-location-pin"></i> {{ $client->address }} <span class="badge badge-success">OPEN</span>
                </p>
                <p class="text-white mb-0"><i class="icofont-food-cart"></i> {{ $menuNames }}
                </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="restaurant-detailed-header-right text-right">
                <button class="btn btn-success" type="button"><i class="icofont-clock-time"></i> 25–35 min
                </button>
                <h6 class="text-white mb-0 restaurant-detailed-ratings"><span class="generator-bg rounded text-white"><i class="icofont-star"></i> 3.1</span> 23 Ratings  <i class="ml-3 icofont-speech-comments"></i> 91 reviews</h6>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div> 
</section>
<section class="offer-dedicated-nav bg-white border-top-0 shadow-sm">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <span class="restaurant-detailed-action-btn float-right">
            <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-heart text-danger"></i> Mark as Favourite</button>
            <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-cauli-flower text-success"></i>  Pure Veg</button>
            <button class="btn btn-outline-danger btn-sm" type="button"><i class="icofont-sale-discount"></i>  OFFERS</button>
            </span>
            <ul class="nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill" href="#pills-order-online" role="tab" aria-controls="pills-order-online" aria-selected="true">Order Online</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="false">Gallery</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="pills-restaurant-info-tab" data-toggle="pill" href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info" aria-selected="false">Restaurant Info</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">Book A Table</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab" aria-controls="pills-reviews" aria-selected="false">Ratings & Reviews</a>
                </li>
            </ul>
        </div>
    </div>
    </div>
</section>
<section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="offer-dedicated-body-left">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                            <div id="#menu" class="bg-white rounded shadow-sm p-4 mb-4 explore-outlets">
                                <h6 class="mb-3">Most Popular  <span class="badge badge-success"><i class="icofont-tags"></i> 15% Off All Items </span></h6>
                                <div class="owl-carousel owl-theme owl-carousel-five offers-interested-carousel mb-3">
                                    
                                    @foreach ($popularProducts as $product)
                                        <div class="item">
                                            <div class="mall-category-item" style="height: 200px;">
                                                <a href="#">
                                                    <img class="img-fluid" src="{{ asset($product->image) }}">
                                                    <h6>{{ $product->name }}</h6>

                                                    @if(is_null($product->discount_price))
                                                        <small>$ {{ $product->price }}</small>
                                                    @else
                                                        <del>{{ $product->price }}</del> <small>$ {{ $product->discount_price }}</small>
                                                    @endif
                                                    
                                                    <a class="btn btn-outline-secondary btn-sm float-right mr-2" href="{{ route('add_to_cart', $product->id) }}">ADD</a>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="mb-4 mt-3 col-md-12">Best Sellers</h5>

                                @foreach ($bestsellerProducts as $product)
                                    <div class="col-md-4 col-sm-6 mb-4">
                                        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                            <div class="list-card-image">
                                                <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                                                <div class="favourite-heart text-danger position-absolute"><a href="#"><i class="icofont-heart"></i></a></div>
                                                <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                                <a href="#">
                                                <img src="{{ asset($product->image) }}" class="img-fluid item-img">
                                                </a>
                                            </div>
                                            <div class="p-3 position-relative">
                                                <div class="list-card-body">
                                                    <h6 class="mb-1"><a href="#" class="text-black">{{ $product->name }}</a></h6>
                                                    <p class="text-gray mb-2">{{ $product->menu->name }}</p>

                                                    <p class="text-gray time mb-0">
                                                        
                                                        @if(is_null($product->discount_price))
                                                            <a class="btn btn-link btn-sm text-black" href="#">$ {{ $product->price }} </a> <span class="float-right"> 
                                                            {{-- <small>$ {{ $product->price }}</small> --}}
                                                        @else
                                                            <a class="btn btn-link btn-sm text-black" href="#"><del>{{ $product->price }}</del> <small>$ {{ $product->discount_price }}</small> </a> <span class="float-right"> 
                                                        @endif
                                                        
                                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('add_to_cart', $product->id) }}">ADD</a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            @foreach($menus as $menu)
                                <div class="row">
                                    <h5 class="mb-4 mt-3 col-md-12">{{ $menu->name }} <small class="h6 text-black-50">{{ $menu->products->count() }} ITEMS</small></h5>
                                    <div class="col-md-12">
                                        <div class="bg-white rounded border shadow-sm mb-4">

                                            @foreach($menu->products as $product)
                                                <div class="menu-list p-3 border-bottom">
                                                    <a class="btn btn-outline-secondary btn-sm  float-right" href="{{ route('add_to_cart', $product->id) }}">ADD</a>
                                                    <div class="media">
                                                        <img class="mr-3 rounded-pill" src="{{ asset($product->image) }}" alt="Generic placeholder image">
                                                        <div class="media-body">
                                                            <h6 class="mb-1">{{ $product->name }}</h6>

                                                            @if(is_null($product->discount_price))
                                                                <p class="text-gray mb-0"><strong>$ {{ $product->price }}</strong> 
                                                                    {{ is_null($product->size) ? '' : ' - ' . $product->size . 'cm' }}
                                                                </p>
                                                            @else
                                                                <p class="text-gray mb-0"><del>{{ $product->price }}</del> <strong>$ {{ $product->discount_price }}</strong> 
                                                                    {{ is_null($product->size) ? '' : ' - ' . $product->size . 'cm' }}
                                                                </p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                            <div id="gallery" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="restaurant-slider-main position-relative homepage-great-deals-carousel">
                                    <div class="owl-carousel owl-theme homepage-ad">

                                        @foreach($galleries as $index => $gallery)
                                            <div class="item">
                                                <img class="img-fluid" src="{{ asset($gallery->image) }}">
                                                <div class="position-absolute restaurant-slider-pics bg-dark text-white">{{ $index + 1 }} of {{ $galleries->count() }} Photos</div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-restaurant-info" role="tabpanel" aria-labelledby="pills-restaurant-info-tab">
                            <div id="restaurant-info" class="bg-white rounded shadow-sm p-4 mb-4">
                                <div class="address-map float-right ml-5">
                                    <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="300" height="170" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=9&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                                    </div>
                                </div>
                                <h5 class="mb-4">{{ $client->name }}</h5>
                                <p class="mb-3">{{ $client->address }}, 
                                    <br> {{ $client->city->name }}
                                </p>
                                <p class="mb-2 text-black"><i class="icofont-phone-circle text-primary mr-2"></i> {{ $client->phone }}</p>
                                <p class="mb-2 text-black"><i class="icofont-email text-primary mr-2"></i> {{ $client->email }}</p>
                                <p class="mb-2 text-black"><i class="icofont-clock-time text-primary mr-2"></i> Today  11am – 5pm, 6pm – 11pm
                                    <span class="badge badge-success"> OPEN NOW </span>
                                <p class="mb-2 text-black"><i class="icofont-info-square text-primary mr-2"></i> {{ $client->shop_info }}
                                </p>
                                <hr class="clearfix">
                                <p class="text-black mb-0">You can also check the 3D view by using our menue map clicking here &nbsp;&nbsp;&nbsp; <a class="text-info font-weight-bold" href="#">Venue Map</a></p>
                                <hr class="clearfix">
                                <h5 class="mt-4 mb-4">More Info</h5>
                                <p class="mb-3">Dal Makhani, Panneer Butter Masala, Kadhai Paneer, Raita, Veg Thali, Laccha Paratha, Butter Naan</p>
                                <div class="border-btn-main mb-4">
                                    <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                    <a class="border-btn text-danger mr-2" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                    <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                                    <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Indoor Seating</a>
                                    <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                    <a class="border-btn text-danger mr-2" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                    <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                            <div id="book-a-table" class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                                <h5 class="mb-4">Book A Table</h5>
                                <form>
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input class="form-control" type="text" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input class="form-control" type="text" placeholder="Enter Email address">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Mobile number</label>
                                            <input class="form-control" type="text" placeholder="Enter Mobile number">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Date And Time</label>
                                            <input class="form-control" type="text" placeholder="Enter Date And Time">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group text-right">
                                    <button class="btn btn-primary" type="button"> Submit </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                            <div id="ratings-and-reviews" class="bg-white rounded shadow-sm p-4 mb-4 clearfix restaurant-detailed-star-rating">
                                <span class="star-rating float-right">
                                <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                                <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                </span>
                                <h5 class="mb-0 pt-1">Rate this Place</h5>
                            </div>
                            <div class="bg-white rounded shadow-sm p-4 mb-4 clearfix graph-star-rating">
                                <h5 class="mb-4">Ratings and Reviews</h5>
                                <div class="graph-star-rating-header">
                                    <div class="star-rating">
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating"></i></a>  <b class="text-black ml-2">334</b>
                                    </div>
                                    <p class="text-black mb-4 mt-2">Rated 3.5 out of 5</p>
                                </div>
                                <div class="graph-star-rating-body">
                                    <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                        5 Star
                                    </div>
                                    <div class="rating-list-center">
                                        <div class="progress">
                                            <div style="width: 56%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-list-right text-black">56%</div>
                                    </div>
                                    <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                        4 Star
                                    </div>
                                    <div class="rating-list-center">
                                        <div class="progress">
                                            <div style="width: 23%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-list-right text-black">23%</div>
                                    </div>
                                    <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                        3 Star
                                    </div>
                                    <div class="rating-list-center">
                                        <div class="progress">
                                            <div style="width: 11%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-list-right text-black">11%</div>
                                    </div>
                                    <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                        2 Star
                                    </div>
                                    <div class="rating-list-center">
                                        <div class="progress">
                                            <div style="width: 2%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-list-right text-black">02%</div>
                                    </div>
                                </div>
                                <div class="graph-star-rating-footer text-center mt-3 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Rate and Review</button>
                                </div>
                            </div>
                            <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
                                <a href="#" class="btn btn-outline-primary btn-sm float-right">Top Rated</a>
                                <h5 class="mb-1">All Ratings and Reviews</h5>
                                <div class="reviews-members pt-4 pb-4">
                                    <div class="media">
                                    <a href="#"><img alt="Generic placeholder image" src="{{ asset('frontend/img/user/1.png') }}" class="mr-3 rounded-pill"></a>
                                    <div class="media-body">
                                        <div class="reviews-members-header">
                                            <span class="star-rating float-right">
                                            <a href="#"><i class="icofont-ui-rating active"></i></a>
                                            <a href="#"><i class="icofont-ui-rating active"></i></a>
                                            <a href="#"><i class="icofont-ui-rating active"></i></a>
                                            <a href="#"><i class="icofont-ui-rating active"></i></a>
                                            <a href="#"><i class="icofont-ui-rating"></i></a>
                                            </span>
                                            <h6 class="mb-1"><a class="text-black" href="#">Singh Osahan</a></h6>
                                            <p class="text-gray">Tue, 20 Mar 2020</p>
                                        </div>
                                        <div class="reviews-members-body">
                                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections </p>
                                        </div>
                                        <div class="reviews-members-footer">
                                            <a class="total-like" href="#"><i class="icofont-thumbs-up"></i> 856M</a> <a class="total-like" href="#"><i class="icofont-thumbs-down"></i> 158K</a> 
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                                <hr>
                                <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#">See All Reviews</a>
                            </div>

                            <div class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                                @guest
                                    <strong>Please login to add a review <a href="{{ route('login') }}">Login here</a></strong>
                                @else
                                    <style>
                                        .star-rating label {
                                            display: inline-flex;
                                            margin-right: 5px;
                                            cursor: pointer;
                                        }
                                        .star-rating input[type='radio'] {
                                            display: none;
                                        }
                                        .star-rating input[type="radio"]:checked + .star-icon {
                                            color: #dd646e;
                                        }
                                    </style>

                                    <h5 class="mb-4">Leave Comment</h5>
                                    <p class="mb-2">Rate the Place</p>
                                    <form method="" action="">
                                        @csrf

                                        <div class="mb-4">
                                            <span class="star-rating">
                                                <label for="rating-1">
                                                <input type="radio" name="rating" id="rating-1" value="1" hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                                <label for="rating-2">
                                                <input type="radio" name="rating" id="rating-2" value="2" hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                                <label for="rating-3">
                                                <input type="radio" name="rating" id="rating-3" value="3" hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                                <label for="rating-4">
                                                <input type="radio" name="rating" id="rating-4" value="4" hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                                <label for="rating-5">
                                                <input type="radio" name="rating" id="rating-5" value="5" hidden><i class="icofont-ui-rating icofont-2x star-icon"></i></label>
                                            </span>
                                        </div>
                                        <div class="form-group">
                                            <label>Your Comment</label>
                                            <textarea class="form-control" name="comment" id="comment"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm" type="button"> Submit Comment </button>
                                        </div>
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pb-2">
                    <div class="bg-white rounded shadow-sm text-white mb-4 p-4 clearfix restaurant-detailed-earn-pts card-icon-overlap">
                        <img class="img-fluid float-left mr-3" src="{{ asset('frontend/img/earn-score-icon.png') }}">
                        <h6 class="pt-0 text-primary mb-1 font-weight-bold">OFFER</h6>

                        @if($coupon)
                            <p class="mb-0">{{ $coupon->discount }}% off {{ $coupon->description }} | Use coupon: <span class="text-danger font-weight-bold">{{ $coupon->name }}</span></p>
                        @else
                            <p class="mb-0"><i>No coupon available at this moment</i></p>
                        @endif
                        <div class="icon-overlap">
                            <i class="icofont-sale-discount"></i>
                        </div>
                    </div>
                </div>
                <div class="generator-bg rounded shadow-sm mb-4 p-4 osahan-cart-item">
                    <h5 class="mb-1 text-white">Your Order</h5>
                    <p class="mb-4 text-white">{{ count((array) session('cart')) }} ITEMS</p>
                    <div class="bg-white rounded shadow-sm mb-2">

                        @php
                            $orderTotal = 0;
                        @endphp

                        @if (session('cart'))
                            @foreach (session('cart') as $product_id => $details)
                                @php
                                    $productTotal = $details['price'] * $details['quantity'];
                                    $orderTotal += $productTotal;
                                @endphp

                                <div class="gold-members p-2 border-bottom">
                                    <p class="text-gray mb-0 float-right ml-2">$ {{ $productTotal }}</p>
                                    <span class="count-number float-right">
                                    <button class="btn btn-outline-secondary btn-sm left dec" data-product_id="{{ $product_id }}"> <i class="icofont-minus"></i> </button>
                                    <input class="count-number-input" type="text" value="{{ $details['quantity'] }}" readonly="">
                                    <button class="btn btn-outline-secondary btn-sm right inc" data-product_id="{{ $product_id }}"> <i class="icofont-plus"></i> </button>
                                    <button class="btn btn-outline-danger btn-sm right remove" data-product_id="{{ $product_id }}"> <i class="icofont-trash"></i> </button>
                                    </span>
                                    <div class="media">
                                        <div class="mr-2"><img src="{{ asset($details['image']) }}" alt="" width="25px"></div>
                                        <div class="media-body">
                                            <p class="mt-1 mb-0 text-black">{{ $details['name'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                    @if (Session::has('coupon'))
                        <div class="mb-2 bg-white rounded p-2 clearfix">
                            <p class="mb-1">Items Total <span class="float-right text-dark">$ {{ $orderTotal }}</span></p>
                            <p class="mb-1">Coupon name <span class="float-right text-dark">{{ (session()->get('coupon')['coupon_name']) }} 
                                ({{ (session()->get('coupon')['discount']) }} %)</span>
                                <a type="submit" onclick="couponRemove()"><i class="icofont-ui-delete float-right" style="color:red"></i></a>
                            </p>
                            <p class="mb-1 text-success">Total Discount 
                                <span class="float-right text-success">
                                    $ {{ $orderTotal - Session()->get('coupon')['discount_amount'] }}
                                </span>
                            </p>
                            <hr />
                            <h6 class="font-weight-bold mb-0">TO PAY  <span class="float-right">$ {{ Session()->get('coupon')['discount_amount'] }}</span></h6>
                        </div>
                    @else
                        <div class="mb-2 bg-white rounded p-2 clearfix">
                            <div class="input-group input-group-sm mb-2">
                                <input type="text" class="form-control" placeholder="Enter promo code" id="coupon_name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="button-addon2" onclick="ApplyCoupon()"><i class="icofont-sale-discount"></i> APPLY</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @php
                        $subTotal = (Session::has('coupon')) ? Session()->get('coupon')['discount_amount'] : $orderTotal;
                    @endphp

                    <div class="mb-2 bg-white rounded p-2 clearfix">
                        <img class="img-fluid float-left" src="{{ asset('frontend/img/wallet-icon.png') }}">
                        <h6 class="font-weight-bold text-right mb-2">Subtotal : <span class="text-danger">$ {{ $subTotal }}</span></h6>
                        <p class="seven-color mb-1 text-right">Extra charges may apply</p>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-success btn-block btn-lg">Checkout <i class="icofont-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        $('.inc').on('click', function() {
            var product_id = $(this).data('product_id');
            var input = $(this).closest('span').find('input');
            var newQuantity = parseInt(input.val()) + 1;
            updateQuantity(product_id, newQuantity);
        })

        $('.dec').on('click', function() {
            var product_id = $(this).data('product_id');
            var input = $(this).closest('span').find('input');
            var newQuantity = parseInt(input.val()) - 1;

            if(newQuantity >= 1) {
                updateQuantity(product_id, newQuantity);
            }
        })

        $('.remove').on('click', function() {
            var product_id = $(this).data('product_id');
            removeFromCart(product_id);
        })

        function updateQuantity(product_id, newQuantity) {
            $.ajax({
                url: '{{ route("cart.updateQuantity") }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: product_id,
                    quantity: newQuantity
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Quantity updated'
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        function removeFromCart(product_id) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: product_id,
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Produce removed from your cart'
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    })
</script>

 @endsection