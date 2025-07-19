@php
   $totalAmount = 0;
   $cart = session()->get('cart', []);
   $groupedCarts = [];

   foreach($cart as $product) {
      $groupedCarts[$product['client_id']][] = $product;
   }

   $clients = App\Models\Client::whereIn('id', array_keys($groupedCarts))->get()->keyBy('id');
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light osahan-nav shadow-sm">
   <div class="container">
      <a class="navbar-brand" href="{{ route('index') }}"><img alt="logo" src="{{ asset('frontend/img/logo.png') }}"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="offers.html"><i class="icofont-sale-discount"></i> Offers <span class="badge badge-danger">New</span></a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Restaurants
               </a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <img alt="Generic placeholder image" src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : 
                  url('upload/no_user.png') }}" class="nav-osahan-pic rounded-pill"> My Account
               </a>
               <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                  <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="icofont-food-cart"></i>Dashboard</a>
                  <a class="dropdown-item" href="{{ route('user.logout') }}"><i class="icofont-sale-discount"></i>Logout</a>
               </div>
            </li>
            <li class="nav-item dropdown dropdown-cart">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-shopping-basket"></i> Cart
               <span class="badge badge-success">{{ count((array) session('cart')) }}</span>
               </a>
               <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">

                  @foreach($groupedCarts as $client_id => $products)
                     @if(isset($clients[$client_id]))
                        @php
                           $client = $clients[$client_id];
                        @endphp
                        <div class="dropdown-cart-top-header p-4">
                           <img class="img-fluid mr-3" alt="osahan" src="{{ asset('upload/client_images/' . $client->photo ) }}">
                           <h6 class="mb-0">{{ $client->name }}</h6>
                           <p class="text-secondary mb-0">{{ $client->address }}</p>
                        </div>
                     @endif
                  @endforeach

                  <div class="dropdown-cart-top-body border-top p-4">

                     @php
                        $orderTotal = 0;
                     @endphp

                     @if (session('cart'))
                        @foreach (session('cart') as $product_id => $details)
                           @php
                              $productTotal = $details['price'] * $details['quantity'];
                              $orderTotal += $productTotal;
                           @endphp
      
                        <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> {{ $details['name'] }} x {{ $details['quantity'] }}  <span class="float-right text-secondary">$ {{ $productTotal }}</span></p>
                        
                        @endforeach
                     @endif

                  </div>
                  <div class="dropdown-cart-top-footer border-top p-4">
                     @php $subTotal = (Session::has('coupon')) ? Session()->get('coupon')['discount_amount'] : $orderTotal; @endphp
                     <p class="mb-0 font-weight-bold text-secondary">Sub Total <span class="float-right text-dark">$ {{ $subTotal }}</span></p>
                  </div>
                  <div class="dropdown-cart-top-footer border-top p-2">
                     <a class="btn btn-success btn-block btn-lg" href="{{ route('checkout') }}"> Checkout</a>
                  </div>
               </div>
            </li>
         </ul>
      </div>
   </div>
</nav>