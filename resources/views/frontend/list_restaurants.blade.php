@extends('frontend.dashboard.dashboard')
@section('dashboard')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<section class="breadcrumb-osahan pt-5 pb-5 bg-dark position-relative text-center">
    <h1 class="text-white">Offers Near You</h1>
    <h6 class="text-white-50">Best deals at your favourite restaurants</h6>
</section>
<section class="section pt-5 pb-5 products-listing">
    <div class="container">
        <div class="row d-none-m">
            <div class="col-md-12">
                <div class="dropdown float-right">
                    <a class="btn btn-outline-info dropdown-toggle btn-sm border-white-btn" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by: <span class="text-theme">Distance</span> &nbsp;&nbsp;
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 ">
                        <a class="dropdown-item" href="#">Distance</a>
                        <a class="dropdown-item" href="#">No Of Offers</a>
                        <a class="dropdown-item" href="#">Rating</a>
                    </div>
                </div>
                <h4 class="font-weight-bold mt-0 mb-3">OFFERS <small class="h6 mb-0 ml-2">299 restaurants
                    </small>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="filters shadow-sm rounded bg-white mb-4">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0">Filter By</h5>
                    </div>

                    @php
                        $categories = App\Models\Category::orderBy('name')->limit(10)->get();
                        $cities = App\Models\City::orderBy('name')->limit(10)->get();
                        $menus = App\Models\Menu::orderBy('name')->limit(10)->get();
                    @endphp

                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingCategory">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                                        Category <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseCategory" class="collapse show" aria-labelledby="headingCategory" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">

                                        @foreach ($categories as $category)
                                            @php
                                                $categoryProductsCount = $products->where('category_id', $category->id)->count();
                                            @endphp

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox" id="category-{{ $category->id }}" 
                                                    data-type="category" data-id="{{ $category->id }}">
                                                <label class="custom-control-label" for="category-{{ $category->id }}">{{ $category->name }} 
                                                    <small class="text-black-50">({{ $categoryProductsCount }})</small>
                                                </label>
                                            </div>
                                        @endforeach

                                        <div class="mt-2"><a href="#" class="link">See all</a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingCity">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseCity" aria-expanded="true" aria-controls="collapseCity">
                                        Cities <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseCity" class="collapse" aria-labelledby="headingCity" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">

                                        @foreach ($cities as $city)
                                            @php
                                                $cityProductsCount = $products->where('city_id', $city->id)->count();
                                            @endphp

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox" id="city-{{ $city->id }}" 
                                                    data-type="city" data-id="{{ $city->id }}">
                                                <label class="custom-control-label" for="city-{{ $city->id }}">{{ $city->name }} 
                                                    <small class="text-black-50">({{ $cityProductsCount }})</small>
                                                </label>
                                            </div>
                                        @endforeach

                                        <div class="mt-2"><a href="#" class="link">See all</a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingMenu">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu">
                                        Menus <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseMenu" class="collapse" aria-labelledby="headingMenu" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">

                                        @foreach ($menus as $menu)
                                            @php
                                                $menuProductsCount = $products->where('menu_id', $menu->id)->count();
                                            @endphp

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input filter-checkbox" id="menu-{{ $menu->id }}" 
                                                    data-type="menu" data-id="{{ $menu->id }}">
                                                <label class="custom-control-label" for="menu-{{ $menu->id }}">{{ $menu->name }} 
                                                    <small class="text-black-50">({{ $menuProductsCount }})</small>
                                                </label>
                                            </div>
                                        @endforeach

                                        <div class="mt-2"><a href="#" class="link">See all</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row" id="product-list">

                    @foreach ($products as $product)
                        <div class="col-md-4 col-sm-6 mb-4 pb-2">
                            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                <div class="list-card-image">
                                    <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                                    <div class="favourite-heart text-danger position-absolute"><a href="{{ route('restaurant.details', $product->client->id) }}"><i class="icofont-heart"></i></a></div>
                                    <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                    <a href="{{ route('restaurant.details', $product->client->id) }}">
                                        <img src="{{ asset($product->image) }}" class="img-fluid item-img">
                                    </a>
                                </div>
                                <div class="p-3 position-relative">
                                    <div class="list-card-body">
                                        <h6 class="mb-1"><a href="{{ route('restaurant.details', $product->client->id) }}" class="text-black">{{ $product->name }}</a></h6>
                                        {{-- <p class="text-gray mb-3">North Indian • American • Pure veg</p> --}}
                                        <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 20–25 min</span> <span class="float-right text-black-50"> $ {{ $product->price }}</span></p>
                                    </div>
                                    <div class="list-card-badge">
                                        <span class="badge badge-success">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.filter-checkbox').on('change', function() {

        })
    })
</script>
 @endsection