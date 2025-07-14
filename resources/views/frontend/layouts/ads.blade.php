@php
    $banners = \App\Models\Banner::orderBy('id', 'desc')
        ->limit(4)
        ->get();
@endphp

<section class="section pt-5 pb-5 bg-white homepage-add-section">
    <div class="container">
        <div class="row">

            @foreach ($banners as $banner)
                <div class="col-md-3 col-6">
                    <div class="products-box">
                        <a href="{{ $banner->url }}" target="_blank">
                            <img alt="{{ $banner->title }}" src="{{ asset($banner->image) }}" class="img-fluid rounded">
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
