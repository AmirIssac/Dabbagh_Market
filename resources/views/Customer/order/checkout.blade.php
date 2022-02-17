@extends('Layouts.main')
@section('content')
<!-- Checkout Section Begin -->
<section style="margin-top: -135px;" class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="#">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fist Name<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Country<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" placeholder="Street Address" class="checkout__input__add">
                            <input type="text" placeholder="Apartment, suite, unite ect (optinal)">
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Country/State<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="acc">
                                Create an account?
                                <input type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <p>Create an account by entering the information below. If you are a returning customer
                            please login at the top of the page</p>
                        <div class="checkout__input">
                            <p>Account Password<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="diff-acc">
                                Ship to a different address?
                                <input type="checkbox" id="diff-acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input">
                            <p>Order notes<span>*</span></p>
                            <input type="text"
                                placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order {{$date}}</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @foreach($cart_items as $item)
                                    @if($item->product->discount)  {{-- product has discount --}}
                                        <?php
                                            $discount_type = $item->product->discount->type;
                                            if($discount_type == 'percent'){
                                                $discount = $item->product->price * $item->product->discount->value / 100;
                                                $new_price = $item->product->price - $discount;
                                            }
                                            else
                                                $new_price = $item->product->price - $item->product->discount->value;
                                        ?>
                                    <li> {{$item->product->name_en}} {{$item->quantity/1000}} K.G <span>{{$new_price * $item->quantity / 1000}} AED</span></li>
                                    @else
                                    <li> {{$item->product->name_en}} {{$item->quantity/1000}} K.G  <span>{{$item->product->price * $item->quantity / 1000}} AED</span></li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>{{$total_order_price}} AED</span></div>
                            <div class="checkout__order__total">Total <span>{{$total_order_price}} AED</span></div>
                            <div class="checkout__input__checkbox">
                                <label for="acc-or">
                                    Create an account?
                                    <input type="checkbox" id="acc-or">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
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

@endsection