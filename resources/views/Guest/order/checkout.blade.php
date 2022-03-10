@extends('Layouts.main')
@section('links')
    <style>
        .taken{
            background-color: #7fad39;
            color: #fff;
        }
        .untaken{
            background-color: #f44336;
            color: #000;
        }
        #complete-profile:hover{
            color: #7fad39;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
<!-- Checkout Section Begin -->
<section style="margin-top: -135px;" class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{route('submit.order.as.guest')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fist Name<span>*</span></p>
                                    <input type="text" name="first_name" value="" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="last_name" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            Address<span style="color: #ff3f32">*</span>
                        <input type="text" name="address2" class="form-control" required>
                        <p>sign up to make your profile and enjoy all the benefits
                        <a style="color: #7fad39; font-weight: bold;" href="{{route('sign.up')}}">sign up</a>
                        </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text" name="phone" value="" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text" name="email" value="" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout__input">
                            <p>Order notes</p>
                            <input type="text" name="customer_note"
                                placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order {{$date}}</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @foreach($cart_items as $item)
                                    @if($item->discount)  {{-- product has discount --}}
                                        <?php
                                            $discount_type = $item->discount->type;
                                            if($discount_type == 'percent'){
                                                $discount = $item->price * $item->discount->value / 100;
                                                $new_price = $item->price - $discount;
                                            }
                                            else
                                                $new_price = $item->price - $item->discount->value;
                                        ?>
                                    <li> {{$item->name_en}}
                                         @if($item->unit == 'gram')
                                         <b style="color: #7fad39">{{$item->quantity/1000}} K.G </b> <span>{{$new_price * $item->quantity / 1000}} AED</span>
                                         @else
                                         <b style="color: #7fad39">{{$item->quantity}}  </b> <span>{{$new_price * $item->quantity}} AED</span>
                                         @endif
                                        </li>
                                    @else
                                    <li> {{$item->name_en}}
                                        @if($item->unit == 'gram')
                                         <b style="color: #7fad39">{{$item->quantity/1000}} K.G </b> <span>{{$item->price * $item->quantity / 1000}} AED</span>
                                        @else
                                        <b style="color: #7fad39">{{$item->quantity}} </b> <span>{{$item->price * $item->quantity}} AED</span>
                                        @endif
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>{{$total_order_price}} AED</span></div>
                            <div class="checkout__order__total">Tax <span>{{$tax}}%</span></div>
                            <?php $tax_value = $tax * $total_order_price / 100 ;
                                  $order_grand_total = $total_order_price + $tax_value ;
                                  $order_grand_total = number_format((float)$order_grand_total, 2, '.', '');
                            ?>
                            <div class="checkout__order__total">Total <span>{{$order_grand_total}} AED</span></div>
                            <div class="checkout__input__checkbox">
                                <label for="cash">
                                    Cash Payment
                                    <input type="radio" name="payment_method" id="cash" value="cash" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="online">
                                    Other
                                    <input type="radio" name="payment_method" value="other" id="online">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@section('scripts')
    <script>
    $('#address2').on('keyup paste',function(){
        if( $(this).val() != '' ){
            $('#address1').removeClass('taken').addClass('untaken');
        }
        else{
            $('#address1').removeClass('untaken').addClass('taken');
        }
    })
    </script>
@endsection
@endsection