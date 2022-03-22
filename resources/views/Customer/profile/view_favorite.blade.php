@extends('Layouts.main')
@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #clear-cart-btn{
        background-color: white;
        border: 1px solid #2b201e;
        border-radius: 5px;
        font-size: 13px;
        font-weight: bold;
        color: black;
    }
    #clear-cart-btn:hover{
        background-color: #2b201e;
        border: 1px solid #2b201e;
        border-radius: 5px;
        font-size: 13px;
        color: white;
    }
    #proceed-to-checkout{
        border: 1px solid white;
    }
    #login-btn{
        border: 1px solid white;
    }
    #checkout-box , #have-account-form{
        filter: drop-shadow(3px 3px 3px #7fad39);
    }
    #min-order-warning{
        color: #dd2222;
        font-weight: bold;
    }
    .displaynone{
        display: none;
    }
</style>
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
                                    <th>1 K.G Price Piece Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>     
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 0 ?>
                                @if($products->count() > 0)
                                @foreach($products as $item)
                                <input type="hidden" value="{{$item->id}}" id="product{{$counter}}">
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{asset('storage/'.$item->image)}}" alt="" height="75px">
                                        <h5>{{$item->name_en}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
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
                                    <input type="hidden" id="final-item-price{{$counter}}" value="{{$new_price}}">
                                    {{$new_price}}
                                    @else
                                        <input type="hidden" id="final-item-price{{$counter}}" value="{{$item->price}}">
                                        {{$item->price}}
                                    @endif
                                    </td>
                                    <td class="shoping__cart__quantity">
                                                <h4>
                                                    {{$item->min_weight}}
                                                
                                                @if($item->unit == 'gram')
                                                g
                                                @endif
                                                </h4>
                                    </td>
                                    <td class="shoping__cart__total">
                                        @if($item->unit == 'gram')    
                                        <input type="hidden" id="single-item-unit{{$counter}}" value="gram">
                                        <input type="hidden" id="single-item-total{{$counter}}" value="{{$item->discount ? ($new_price * $item->min_weight) / 1000 : ($item->price * $item->min_weight) / 1000}}">
                                        <h3 id="h-item-total{{$counter}}">{{$item->discount ? ($new_price * $item->min_weight) / 1000 : ($item->price * $item->min_weight) / 1000}}</h6>
                                        @else
                                        <input type="hidden" id="single-item-unit{{$counter}}" value="piece">
                                        <input type="hidden" id="single-item-total{{$counter}}" value="{{$item->discount ? $new_price * $item->min_weight : $item->price * $item->min_weight}}">
                                        <h3 id="h-item-total{{$counter}}">{{$item->discount ? $new_price * $item->min_weight : $item->price * $item->min_weight}}</h6>
                                        @endif
                                    </td>
                                    <td class="shoping__cart__item__close">
                                            <button style="border: none; background-color: transparent" onclick="javascript:this.form.submit();" class="icon_close"></button>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                                @endforeach
                                @else {{-- Empty favorite --}}
                                <tr>
                                    <td>
                                        <span class="badge badge-danger">empty</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">none</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">none</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">none</span>
                                    </td>
                                </tr>
                                @endif
                                <input type="hidden" value="{{$counter}}" id="cart-rows"> {{-- number of rows in favorite --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@section('scripts')
<script>

</script>
@endsection
@endsection