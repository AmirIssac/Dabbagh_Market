@extends('Layouts.main')
@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #add-to-cart{
        border: 1px solid #ffffff;
    }
</style>
@endsection
@section('content')
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div style="margin-top:-100px" class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{asset('storage/'.$product->image)}}" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @if($product->productImages->count() > 0)
                            @foreach($product->productImages as $product_image)
                            <img data-imgbigurl="{{asset('storage/'.$product_image->image)}}"
                                src="{{asset('storage/'.$product_image->image)}}" alt="">
                            @endforeach
                            @else {{-- there is no additional images --}}
                            <img data-imgbigurl="{{asset('storage/'.$product->image)}}"
                                src="{{asset('storage/'.$product->image)}}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{$product->name_en}}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        
                        @if($product->discount)  {{-- product has discount --}}
                                    <h6 style="text-decoration: line-through; color: #f44336">    {{$product->price}}  </h6>
                                    <?php
                                        $discount_type = $product->discount->type;
                                        if($discount_type == 'percent'){
                                            $discount = $product->price * $product->discount->value / 100;
                                            $new_price = $product->price - $discount;
                                        }
                                        else
                                            $new_price = $product->price - $product->discount->value;
                                    ?>
                                    <input style="display: none;" type="number" id="initial-price" value="{{$new_price}}">
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$new_price}}" readonly/>AED</div>
                        @else
                                    <input style="display: none;" type="number" id="initial-price" value="{{$product->price}}">
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$product->price}}" readonly/>AED</div>
                        @endif

                        <p>{{$product->description}}</p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input id="quantity-input" type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <input style="height:40px; width:100px; font-size:30px; border:0px solid white" id="weight-input" type='text' name='name' value="{{$product->unit == 'gram' ? '500g' : '1 piece'}}" readonly/>
                        <input type="hidden" id="unit" value="{{$product->unit}}">
                        <input type="hidden" id="product-id" value="{{$product->id}}">
                        @if($product->availability)
                        <button id="add-to-cart" class="primary-btn"> ADD TO CART <i class="fa fa-cart-plus"></i> </button>
                        @else
                        <button id="add-to-cart" class="disabled-btn" disabled> ADD TO CART <i class="fa fa-exclamation-circle"></i> </button>
                        @endif
                        {{--<a href="#" class="primary-btn">ADD TO CART</a>--}}
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <ul>
                            <li><b>Availability</b>
                                 @if($product->availability)
                                 <span style="color: #7fad39; font-weight: bold;">available</span>
                                 @else
                                 <span style="color: #f44336; font-weight: bold;">sorry , not available now</span>
                                 @endif
                            </li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            @if($product->unit == 'gram')
                            <li><b>Min weight</b> <span>500 g</span></li>
                            @else
                            <li><b>Min quantity</b> <span>1 piece</span></li>
                            @endif
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Reviews <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                        suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                        vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                        Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                        accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                        pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                        elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                        et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                        vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                                        <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                        ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                        elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                        porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                        nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                        Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                        porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                        sed sit amet dui. Proin eget tortor risus.</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                        Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                        sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                        eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                        Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                        sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                        diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                        ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                        Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                        Proin eget tortor risus.</p>
                                    <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                        ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                        elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                        porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                        nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                        Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                        Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                        sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                        eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                        Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                        sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                        diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                        ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                        Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                        Proin eget tortor risus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
@section('scripts')
<script>
        /*function addToCart(){*/
    $('document').ready(function(){
        $('#add-to-cart').on('click',function(){
            var product_id = $('#product-id').val();
            var qty = parseInt($('#quantity-input').val());
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: '/add/product/toCart/'+product_id,
                data : { quantity : qty },
                //dataType: 'json',
                success: function(data){    // data is the response come from controller
                    if(data == 'success')
                        alert('added to cart !!');
                }
            }); // ajax close
        });
    });
</script>
@endsection
@endsection