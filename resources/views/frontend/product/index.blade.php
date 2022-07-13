@extends('layouts.frontend.app')
<!-- Content Wrapper -->
@section('content')


<div id="content-wrapper" class="d-flex flex-column">
	<!-- Main Content -->
	<div id="content">
		<!-- Begin Page Content -->
		<div class="container-fluid">
			<!-- Page Heading -->
			<div>
				<h1 class="homeheading">Store</h1>
			</div>
			<div class="row">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="store-item">
                            <img src="{{ asset('storage/'.$product->images->img) }}">
                            <div class="product">
                                <div class="product-name">
                                    <h4>
                                        @if ($product->heading)
                                            {{ (Str::length($product->heading) > 27) ? Str::substr($product->heading, 0, 27)."..." : $product->heading }}
                                        @else

                                        @endif
                                    </h4>
                                </div>
                                <div class="product-price">
                                    <p>&#8377;{{ $product->discount_price }}</p>
                                    <p class="colorp">&#8377;{{ $product->actual_price }}</p>
                                </div>
                            </div>
                            <div class="product-desc">
                                <p>
                                    {{strlen($product->description) > 105 ?  substr($product->description,0,105)."..." : $product->description }}
                                </p>
                            </div>
                            <div class="buy"><a class="productbuy" @if($product->product_link) href="{{ $product->product_link }}" target="_blank" @else href="javascript:void(0)" @endif>{{ $product->button_label }}</a></div>
                        </div>
                    </div>
                    @empty
                        <p>No Products Available</p>
                    @endforelse
			</div>
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->


@endsection

