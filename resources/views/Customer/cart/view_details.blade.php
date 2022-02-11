@extends('Layouts.main')
@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Shoping Cart Section Begin -->
    <section style="margin-top:-100px;" class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 0 ?>
                                @foreach($cart_items as $item)
                                <input type="hidden" value="{{$item->product->id}}" id="product{{$counter}}">
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{asset('storage/'.$item->product->image)}}" alt="" width="50px" height="50px">
                                        <h5>{{$item->product->name_en}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
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
                                    <input type="hidden" id="final-item-price{{$counter}}" value="{{$new_price}}">
                                    {{$new_price}}
                                    @else
                                        <input type="hidden" id="final-item-price{{$counter}}" value="{{$item->product->price}}">
                                        {{$item->product->price}}
                                    @endif
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="cart-qty">
                                                <span class="{{$counter}}qty dec cartqtybtn">-</span>
                                                <input type="text" value="{{$item->quantity}}" id="quantity-input{{$counter}}">
                                                <span class="{{$counter}}qty inc cartqtybtn" id="qty{{$counter}}">+</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        {{--
                                        {{$item->product->price * $item->quantity}}
                                        --}}
                                        {{--
                                        @if($item->product->discount)  {{-- product has discount 
                                            {{$new_price * $item->quantity}}
                                        @else
                                            {{$item->product->price * $item->quantity}}
                                        @endif
                                        --}}
                                        <input type="text" id="single-item-total{{$counter}}" value="{{$item->product->discount ? $new_price * $item->quantity : $item->product->price * $item->quantity}}">
                                        {{--
                                        <h6 id="h-item-total{{$counter}}"></h6>
                                        --}}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <form action="{{route('delete.cart.item',$item->id)}}" method="POST">
                                            @csrf
                                            {{--
                                            <span onclick="javascript:this.form.submit();" class="icon_close"></span>
                                            --}}
                                            <button style="border: none; background-color: transparent" onclick="javascript:this.form.submit();" class="icon_close"></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$454.98</span></li>
                            <li>Total <span>$454.98</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@section('scripts')
<script>
    /*-------------------
		Cart Live Quantity change
	--------------------- */
   // proQty.prepend('<span class="dec qtybtn">-</span>');
   // proQty.append('<span class="inc qtybtn">+</span>');
    $('.cart-qty').on('click', '.cartqtybtn', function () {
        var proQty = $(this);
        //alert($(this).attr('id'));
        //var gold = proQty.attr('id');//.substring(3);
        var gold= proQty.attr('class').substr(0, proQty.attr('class').indexOf('q'));
        var product_id = $('#product'+gold).val();
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        //alert(gold);
       // alert(product_id);
            //var newVal = parseFloat(oldValue) + 1;
                //var id = $(this).data("id");
                //alert(gold);
                var token = $("meta[name='csrf-token']").attr("content");
                var quantity = $('#quantity-input'+gold).val();
                $.ajax(
                {
                    url: "/update/product/inCart/"+product_id,
                    type: 'POST',
                    data: {
                        "quantity": quantity,
                        "_token": token,
                    },
                    success: function (){
                        $('#single-item-total'+gold).val(parseFloat($('#final-item-price'+gold).val()) * quantity);
                        //alert('success !');
                    }
                });
                
        
       
    });
</script>
@endsection
@endsection