    @extends('Layouts.main')
    @section('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    @section('content')
   

    <!-- Featured Section Begin -->
        <div style="margin-top:-50px" class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured__controls">
                        <ul>
                            {{--
                            <li class="active" data-filter="*">All</li>
                            <li data-filter=".oranges">type 1</li>
                            <li data-filter=".fresh-meat">type 2</li>
                            <li data-filter=".vegetables">type 3</li>
                            <li data-filter=".{{$category->name_en}}">type 4</li>
                            --}}
                            {{--
                            <li class="active">All</li>
                            --}}
                            @if(isset($category)) {{-- index by specific category --}}
                                @foreach($categories as $cat)
                                <li class="{{$cat->id == $category->id ? 'active-category' : 'no'}}">
                                    <a href="{{route('index.by.category',$cat->id)}}">{{$cat->name_en}}</a>
                                </li>
                                @endforeach
                            @else {{-- All --}}
                                @foreach($categories as $category)
                                    <li><a href="{{route('index.by.category',$category->id)}}">{{$category->name_en}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <!--
                <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img/meats/5011LamFlaps.jpg">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">5011LamFlaps</a></h6>
                            <h5>30.00 AED</h5>
                        </div>
                    </div>
                </div>
                -->
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{$product->category->name_en}}">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{asset('storage/'.$product->image)}}">
                            <ul class="featured__item__pic__hover">
                                <li>
                                    <a href=""><i class="fa fa-heart"></i></a>
                                </li>
                                <li><a href="{{route('view.product',$product->id)}}"><i class="fa fa-eye"></i></a></li>
                                <li>
                                    @if($product->availability)
                                    <button id="add-to-cart-{{$product->id}}"><i class="fa fa-shopping-cart"></i></button>
                                    @else
                                    <button id="disabled-cart"><i class="fa fa-shopping-cart"></i></button>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6 style="font-weight: bold;"><a href="#">{{$product->name_en}}</a></h6>
                            <h5>
                                @if(!$product->availability)
                                <span class="badge badge-danger">not available now</span>
                                @endif
                              {{--  {{$product->price}} AED  --}}
                            </h5>
                            @if($product->hasDiscount())  {{-- product has discount --}}
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
                                    <h5 style="color: #7fad39">{{$new_price}} AED</h5>
                            @else
                                    <h5 style="color: #7fad39">{{$product->price}} AED</h5>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    <!-- Featured Section End -->


     <!-- Categories Section Begin -->
     <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{asset('img/meats/4500LambC.jpg')}}">
                            <h5><a href="#">4500LambC</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{asset('img/meats/4860LambLoin.jpg')}}">
                            <h5><a href="#">4860LambLoin</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{asset('img/meats/4933LambRack.jpg')}}">
                            <h5><a href="#">4933LambRack</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{asset('img/meats/4991LamScut.jpg')}}">
                            <h5><a href="#">4991LamScut</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="{{asset('img/meats/5011LamFlaps.jpg')}}">
                            <h5><a href="#">5011LamFlaps</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->


    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('img/banner/banner-1.jpg')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{asset('img/meats/lamb-banner-1.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Review Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-1.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-2.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="{{asset('img/latest-product/lp-3.jpg')}}" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('img/blog/blog-1.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('img/blog/blog-2.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="{{asset('img/blog/blog-3.jpg')}}" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

    @section('scripts')
    <script>
    $('[id^=add-to-cart-]').on('click',function(){
        var product_id = parseInt($(this).attr('id').slice(12));
        var qty = 1 ;
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
    </script>
    @endsection
    @endsection