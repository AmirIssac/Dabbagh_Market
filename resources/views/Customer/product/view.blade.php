@extends('Layouts.main')
@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #add-to-cart{
        border: 1px solid #ffffff;
    }
    #favorite-btn,#unfavorite-btn{
        background: none!important;
        border: none;
        padding: 0!important;
        /*optional*/
        font-family: arial, sans-serif;
        /*input has OS specific font-family*/
        color: #069;
        text-decoration: underline;
        cursor: pointer;
    }
    .displaynone{
        display: none;
    }
    .star-btn{
        border: none;
        background-color: transparent;
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
                        <input type="hidden" value="{{$product->name_en}}" id="product-name">
                        <div class="product__details__rating">
                            {{--
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                            --}}
                            @for($k=1;$k<=$rate;$k++)
                            <i class="fa fa-star"></i>
                            @endfor
                            <span>({{$reviews}} reviews)</span>
                        </div>
                        
                        @if($product->hasDiscount())  {{-- product has discount --}}
                                    <h6 style="text-decoration: line-through; color: #f44336"> {{$product->price}} </h6>
                                    <?php
                                        if($product->isPercentDiscount()){
                                            $discount = $product->price * $product->discount->value / 100;
                                            $new_price = $product->price - $discount;
                                        }
                                        else
                                            $new_price = $product->price - $product->discount->value;
                                    ?>
                                    @if($product->unit == 'gram')
                                    {{-- FOR 1 KG --}}
                                    <input style="display: none;" type="number" id="initial-price" value="{{$new_price}}">
                                    <div><input style="height:40px; font-size:18px; color:#7fad39; border:0px solid white" type='text' name='name' value="{{$new_price.' for 1 K.G'}}" readonly/></div>
                                    {{-- final price --}}
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$new_price * $product->min_weight / 1000}}" readonly/>AED</div>
                                    @else  {{-- By piece --}}
                                    <input style="display: none;" type="number" id="initial-price" value="{{$new_price}}">
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$new_price * $product->min_weight}}" readonly/>AED</div>
                                    @endif
                        @else
                                    @if($product->unit == 'gram')
                                    {{-- FOR 1 KG --}}
                                    <input style="display: none;" type="number" id="initial-price" value="{{$product->price}}">
                                    <div><input style="height:40px; font-size:18px; color:#7fad39; border:0px solid white" type='text' name='name' value="{{$product->price.' for 1 K.G'}}" readonly/></div>
                                    {{-- final price --}}
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$product->price * $product->min_weight / 1000}}" readonly/>AED</div>
                                    @else  {{-- By piece --}}
                                    <input style="display: none;" type="number" id="initial-price" value="{{$product->price}}">
                                    <div class="product__details__price"><input class="product__details__price" style="height:40px; width:100px; font-size:30px; border:0px solid white" id="price-input" type='number' name='name' value="{{$product->price * $product->min_weight}}" readonly/>AED</div>
                                    @endif
                        @endif
                                    
                        <p>{{$product->description}}</p>
                        <div class="product__details__quantity">
                            <input type="hidden" id="increase-by" value="{{$product->increase_by}}">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input id="quantity-input" type="text" value="1">
                                </div>
                            </div>
                        </div>
                        @if($product->unit == 'gram')
                        <input style="height:40px; width:100px; font-size:30px; border:0px solid white" id="weight-input" type='text' name='name' value="{{($product->min_weight / 1000).' K.G'}}" readonly/>
                        {{--
                        @elseif($product->unit == 'gram' && $product->min_weight < 1000)
                        <input style="height:40px; width:100px; font-size:30px; border:0px solid white" id="weight-input" type='text' name='name' value="{{$product->min_weight.' g'}}" readonly/>
                        --}}
                        @elseif($product->unit == 'piece')
                        <input style="height:40px; width:100px; font-size:30px; border:0px solid white" id="weight-input" type='hidden' name='name' value="{{$product->min_weight.' piece'}}" readonly/>
                        @endif
                        <input type="hidden" id="unit" value="{{$product->unit}}">
                        <input type="hidden" id="min_weight" value="{{$product->min_weight}}">
                        <input type="hidden" id="product-id" value="{{$product->id}}">
                        <input style="display: none"  id="weight-in-gram" type='number' name='weight' value="{{$product->unit == 'gram' ? $product->min_weight : $product->min_weight}}" readonly/>
                        @if($product->availability)
                        <button id="add-to-cart" class="primary-btn"> ADD TO CART <i class="fa fa-cart-plus"></i> </button>
                        @else
                        <button id="add-to-cart" class="disabled-btn" disabled> ADD TO CART <i class="fa fa-exclamation-circle"></i> </button>
                        @endif
                        {{--<a href="#" class="primary-btn">ADD TO CART</a>--}}
                        {{--
                        <button class="heart-icon"><span class="icon_heart_alt"></span></button>
                        --}}
                        @auth
                        @if($user->favorite->products->count() > 0)  {{-- user favorite contain products --}}
                                @if($user->favorite->products->contains('id', $product->id))
                                    <button id="favorite-btn" class="to-favorite"><img src="{{asset('img/pngs/red-heart.png')}}" height="35px"></button>
                                    <button id="unfavorite-btn" class="to-favorite displaynone"><img src="{{asset('img/pngs/empty-heart.png')}}" height="35px"></button>
                                @else
                                    <button id="favorite-btn" class="to-favorite displaynone"><img src="{{asset('img/pngs/red-heart.png')}}" height="35px"></button>
                                    <button id="unfavorite-btn" class="to-favorite"><img src="{{asset('img/pngs/empty-heart.png')}}" height="35px"></button>
                                @endif
                        @else       
                                <button id="favorite-btn" class="to-favorite displaynone"><img src="{{asset('img/pngs/red-heart.png')}}" height="35px"></button>
                                <button id="unfavorite-btn" class="to-favorite"><img src="{{asset('img/pngs/empty-heart.png')}}" height="35px"></button>                 
                        @endif
                        @endauth
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
                            <li><b>Min weight</b> <span>{{$product->min_weight}} gram</span></li>
                            @else
                            <li><b>Min quantity</b> <span>{{$product->min_weight}} piece</span></li>
                            @endif

                            @if(Auth::user())
                                @if(!$exist_rate)
                                    <li><b>Rate this product</b>
                                        <div class="share">
                                            <form action="{{route('rate.product',$product->id)}}" method="POST">
                                            @for($i=1;$i<=5;$i++)
                                                    @csrf
                                                    <button class="star-btn" id="star-btn-{{$i}}" name="rate" value="{{$i}}">
                                                    <img src="{{asset('img/pngs/empty-star.png')}}" height="35px" id="empty-star-{{$i}}">
                                                    <img src="{{asset('img/pngs/star.png')}}" height="35px" class="displaynone" id="star-{{$i}}">
                                                    </button>
                                            @endfor
                                            </form>
                                        </div>
                                    </li>
                                @else
                                    <li><b>Thanx for rating</b>
                                        <div class="share">
                                            @for($i=1;$i<=$user_rate_val;$i++)
                                                    <img src="{{asset('img/pngs/star.png')}}" height="35px">
                                            @endfor
                                            @for($i=$user_rate_val+1;$i<=5;$i++)
                                                    <img src="{{asset('img/pngs/empty-star.png')}}" height="35px">
                                            @endfor
                                        </div>
                                    </li>
                                @endif
                            @else {{-- Not auth --}}
                               
                            @endif
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
    function addToCartNotification(from, align){
        color = 'success';
        name = $('#product-name').val();
        if($('#unit').val() == 'gram'){
            unit = 'K.G' ;
            weight = $('#weight-in-gram').val() / 1000;
        }
        else{
            unit = 'pieces' ;
            weight = $('#weight-in-gram').val();
        }

        $.notify({
            message: "added to cart <b> "+name+" "+weight+" "+unit,
        },{
            type: color,
            timer: 20,
            placement: {
                from: from,
                align: align
            }
        });
    }
    function addToFavoriteNotification(from, align){
        color = 'info';
        name = $('#product-name').val();
        $.notify({
            message: "Added <b>"+name+"</b> to favorite",
        },{
            type: color,
            timer: 20,
            placement: {
                from: from,
                align: align
            }
        });
    }
    function removeFromFavoriteNotification(from, align){
        color = 'danger';
        name = $('#product-name').val();
        $.notify({
            message: "Remove <b>"+name+"</b> from favorite",
        },{
            type: color,
            timer: 20,
            placement: {
                from: from,
                align: align
            }
        });
    }
        /*function addToCart(){*/
    $('document').ready(function(){
        $('#add-to-cart').on('click',function(){
           // var product_id = $('#product-id').val();
           var product_id = {!! json_encode($product->id, JSON_HEX_TAG) !!};
            //var qty = parseInt($('#quantity-input').val());
            var qty = parseInt($('#weight-in-gram').val());
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
                        //nowuiDashboard.showNotification('top','center','Added to Cart','success');
                        addToCartNotification('top','center');
                }
            }); // ajax close
        });


        $('.to-favorite').on('click',function(){
            //var product_id = $('#product-id').val();
            var product_id = {!! json_encode($product->id, JSON_HEX_TAG) !!};
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: '/add/product/toFavorite/'+product_id,
                success: function(data){    // data is the response come from controller
                    if(data == 'added'){
                        $('#unfavorite-btn').addClass('displaynone');
                        $('#favorite-btn').removeClass('displaynone');
                        addToFavoriteNotification('top','center');
                        //alert('added to favorite !!');
                    }
                    else{
                        $('#favorite-btn').addClass('displaynone');
                        $('#unfavorite-btn').removeClass('displaynone');
                        removeFromFavoriteNotification('top','center');
                        //alert('removed from favorite !!');
                    }
                }
            }); // ajax close
        });
    });

    $("[id^='star-btn-']").hover(function() {
        var gold = $(this).attr('id').slice(9);  // number of star
        for(var i = parseInt(gold) ; i >= 1 ; --i ){  // fill
            $('#empty-star-'+i).addClass('displaynone');
            $('#star-'+i).removeClass('displaynone');
        }
        for( i = parseInt(gold)+1 ; i <= 5 ; ++i ){  // gaping
            $('#star-'+i).addClass('displaynone');
            $('#empty-star-'+i).removeClass('displaynone');
        }
    });
</script>
@endsection
@endsection