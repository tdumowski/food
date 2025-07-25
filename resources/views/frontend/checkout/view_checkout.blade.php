@extends('frontend.dashboard.dashboard')
@section('dashboard')

@php
    $userId = Auth::user()->id;
    $profileData = App\Models\User::find($userId);
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    /**
    * The CSS shown here will not be introduced in the Quickstart guide, but shows
    * how you can use CSS to style your Element's container.
    */
    .StripeElement {
        box-sizing: border-box; 
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>

<section class="offer-dedicated-body mt-4 mb-4 pt-2 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="offer-dedicated-body-left">
                    <div class="pt-2"></div>
                        <div class="bg-white rounded shadow-sm p-4 mb-4">
                        <h4 class="mb-1">Choose a delivery address</h4>
                        <h6 class="mb-3 text-black-50">Multiple addresses in this location</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-white card addresses-item mb-4 border border-success">
                                    <div class="gold-members p-4">
                                        <div class="media">
                                            <div class="mr-3"><i class="icofont-ui-home icofont-3x"></i></div>
                                            <div class="media-body">
                                                <h6 class="mb-1 text-black">Home</h6>
                                                <p class="text-black">291/d/1, 291, Jawaddi Kalan, Ludhiana, Punjab 141002, India</p>
                                                <p class="mb-0 text-black font-weight-bold"><a class="btn btn-sm btn-success mr-2" href="#"> DELIVER HERE</a> 
                                                    <span>30MIN</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white card addresses-item mb-4">
                                    <div class="gold-members p-4">
                                        <div class="media">
                                            <div class="mr-3"><i class="icofont-briefcase icofont-3x"></i></div>
                                            <div class="media-body">
                                                <h6 class="mb-1 text-secondary">Work</h6>
                                                <p>NCC, Model Town Rd Town, Ludhiana, Punjab 141002, India
                                                </p>
                                                <p class="mb-0 text-black font-weight-bold"><a class="btn btn-sm btn-secondary mr-2" href="#"> DELIVER HERE</a> 
                                                    <span>40MIN</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2"></div>
                    <div class="bg-white rounded shadow-sm p-4 osahan-payment">
                        <h4 class="mb-1">Choose payment method</h4>
                        <h6 class="mb-3 text-black-50">Credit/Debit Cards</h6>
                        <div class="row">
                            <div class="col-sm-4 pr-0">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-cash-tab" data-toggle="pill" href="#v-pills-cash" role="tab" aria-controls="v-pills-cash" aria-selected="false"><i class="icofont-money"></i> Pay on Delivery</a>
                                    <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="icofont-credit-card"></i> Credit/Debit Cards</a>
                                </div>
                            </div>
                            <div class="col-sm-8 pl-0">
                                <div class="tab-content h-100" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-cash" role="tabpanel" aria-labelledby="v-pills-cash-tab">
                                        <h6 class="mb-3 mt-0">Cash</h6>
                                        <p>Please keep exact change handy to help us serve you better</p>
                                        <hr>
                                        <form action="{{ route('cash.order') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                            <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                                            <input type="hidden" name="address" value="{{ Auth::user()->address }}">
                                            <button type="submit" class="btn btn-success btn-block btn-lg">PAY
                                            <i class="icofont-long-arrow-right"></i></button>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <h6 class="mb-3 mt-0">Add new card</h6>
                                        <p>WE ACCEPT <span class="osahan-card">
                                            <i class="icofont-visa-alt"></i> <i class="icofont-mastercard-alt"></i> <i class="icofont-american-express-alt"></i> <i class="icofont-payoneer-alt"></i> <i class="icofont-apple-pay-alt"></i> <i class="icofont-bank-transfer-alt"></i> <i class="icofont-discover-alt"></i> <i class="icofont-jcb-alt"></i>
                                            </span>
                                        </p>
                                        <form action="{{ route('stripe.order') }}" method="post" id="payment-form">
                                            @csrf

                                            <label for="card-element"></label>
                                            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                            <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                                            <input type="hidden" name="address" value="{{ Auth::user()->address }}">

                                            <div id="card-element"></div>
                                            <div id="card-error" role="alert"></div>

                                            <button type="submit" class="btn btn-success btn-block btn-lg mt-3">PAY
                                                <i class="icofont-long-arrow-right"></i>
                                            </button>
                                        </form>

                                        {{-- <form> --}}
                                            {{-- <div class="form-row">
                                                {{-- <div class="form-group col-md-12">
                                                    <label for="inputPassword4">Card number</label>
                                                    <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="Card number">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="icofont-card"></i></button>
                                                    </div>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="form-group col-md-8">
                                                    <label>Valid through(MM/YY)
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="Enter Valid through(MM/YY)">
                                                </div> --}}
                                                {{-- <div class="form-group col-md-4">
                                                    <label>CVV
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="Enter CVV Number">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Name on card
                                                    </label>
                                                    <input type="text" class="form-control" placeholder="Enter Card number">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Securely save this card for a faster checkout next time.</label>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="form-group col-md-12 mb-0">
                                                    <a href="thanks.html" class="btn btn-success btn-block btn-lg">PAY $1329
                                                    <i class="icofont-long-arrow-right"></i></a>
                                                </div>
                                            </div> --}}
                                        {{-- </form> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="generator-bg rounded shadow-sm mb-4 p-4 osahan-cart-item">
                    <div class="d-flex mb-4 osahan-cart-item-profile">
                        <img class="img-fluid mr-3 rounded-pill" src="{{ (!empty($profileData->photo)) ? url('upload/user_images/' . $profileData->photo) : 
                                url('upload/no_user.png') }}" width="30" height="30"></div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-white">{{ $profileData->name }}
                            </h6>
                            <p class="mb-0 text-white"><i class="icofont-location-pin"></i> {{ $profileData->address }}</p>
                        </div>
                    </div>
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
                    <div class="mb-2 bg-white rounded p-2 clearfix">
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" class="form-control" placeholder="Enter promo code">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="button-addon2"><i class="icofont-sale-discount"></i> APPLY</button>
                            </div>
                        </div>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icofont-comment"></i></span>
                            </div>
                            <textarea class="form-control" placeholder="Any suggestions? We will pass it on..." aria-label="With textarea"></textarea>
                        </div>
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
                            <p class="mb-1">Items Total <span class="float-right text-dark">$ {{ $orderTotal }}</span></p>
                            </p>
                            <p class="mb-1 text-success">Total Discount 
                                <span class="float-right text-success">
                                    $ {{ $orderTotal }}
                                </span>
                            </p>
                            <hr />
                            <h6 class="font-weight-bold mb-0">TO PAY $ {{ $orderTotal }}</span></h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    // Create a Stripe client.
    var stripe = Stripe('pk_test_51RncVGPJr6sFH5YYTvz42CKKRMsRWro4QatrUPhS2AsEgRUbKprt0uaYXG6zRcUHzYil8mFGS6vw87MLzbjcCtoq004wwiXv6h');
    // Create an instance of Elements.
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    // Handle real-time validation errors from the card Element.
    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
            }
        });
    });
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form
        form.submit();
    }
</script>

@endsection