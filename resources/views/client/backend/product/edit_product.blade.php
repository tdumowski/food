@extends('client.client_dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Product</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-4">
                        <form id="myForm" action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Category</label>
                                        <select name="category_id" class="form-select">
                                            <option value="" disabled selected hidden>Please choose...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" 
                                                    {{ $product->category_id == $category->id ? "selected" : "" }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Menu</label>
                                        <select name="menu_id" class="form-select">
                                            <option value="" disabled selected hidden>Please choose...</option>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" 
                                                    {{ $product->menu_id == $menu->id ? "selected" : "" }}>
                                                    {{ $menu->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">City</label>
                                        <select name="city_id" class="form-select">
                                            <option value="" disabled selected hidden>Please choose...</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" 
                                                    {{ $product->city_id == $city->id ? "selected" : "" }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Product name</label>
                                        <input class="form-control" name="name" type="text" id="example-text-input" value="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Price</label>
                                        <input class="form-control" name="price" type="text" id="example-text-input" value="{{ $product->price }}">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Discount price</label>
                                        <input class="form-control" name="discount_price" type="text" id="example-text-input" value="{{ $product->discount_price }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Size</label>
                                        <input class="form-control" name="size" type="text" id="example-text-input" value="{{ $product->size }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Quantity</label>
                                        <input class="form-control" name="qty" type="text" id="example-text-input" value="{{ $product->qty }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Image</label>
                                        <input class="form-control" name="image" type="file" id="image">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ asset($product->image) }}" 
                                            alt="" class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input name="best_seller" class="form-check-input" type="checkbox" id="formCheck1" value="1"
                                        {{ $product->best_seller ? 'checked' : '' }}>
                                    <label class="form-check-label" for="formCheck1">
                                        Best Seller
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input name="most_popular" class="form-check-input" type="checkbox" id="formCheck2" value="1" 
                                        {{ $product->most_popular ? 'checked' : '' }}>
                                    <label class="form-check-label" for="formCheck2">
                                        Most Popular
                                    </label>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                                </div>

                            </div>
                        </form>
                    <!-- end card body -->
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                category_id: {
                    required : true,
                }, 
                menu_id: {
                    required : true,
                }, 
                city_id: {
                    required : true,
                }, 
                price: {
                    required : true,
                }, 
            },
            messages :{
                name: {
                    required : 'Please enter product name',
                }, 
                category_id: {
                    required : 'Please select product category',
                }, 
                menu_id: {
                    required : 'Please select menu',
                }, 
                city_id: {
                    required : 'Please select city',
                }, 
                price: {
                    required : 'Please input product price',
                }, 
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>
@endsection