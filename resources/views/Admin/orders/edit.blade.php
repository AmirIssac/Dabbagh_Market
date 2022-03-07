@extends('Layouts.dashboard_main')
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
  <div class="row">
    <div class="col-md-12 ml-auto mr-auto">
      <div class="card card-upgrade">
        <div class="card-header text-center">
          <h4 class="card-title"> <span class="badge badge-primary"> #{{$order->number}} </span> </h3>
            <p class="card-category"></p>
        </div>
        <div class="card-body">
          <div class="table-responsive table-upgrade">
            <table class="table">
              <thead>
                <th style="font-weight: bold">Customer</th>
                <th style="font-weight: bold" class="text-center">Total</th>
                <th style="font-weight: bold" class="text-center">Status</th>
                <th style="font-weight: bold" class="text-center">Address</th>
                <th style="font-weight: bold" class="text-center">Note</th>
              </thead>
              <tbody>
                <tr style="font-weight: bold">
                  <td>{{$order->user->profile->first_name}}</td>
                  <td class="text-center"><span class="badge badge-success">{{$order->total}}</span></td>
                  <td class="text-center">
                      @if($order->status == 'pending')
                      <span class="badge badge-warning"> {{$order->status}} </span>
                      @elseif($order->status == 'preparing' || $order->status == 'shipping')
                      <span class="badge badge-info"> {{$order->status}} </span>
                      @elseif($order->status == 'delivered')
                      <span class="badge badge-success"> {{$order->status}} </span>
                      @elseif($order->status == 'failed' || $order->status == 'cancelled' || $order->status == 'rejected')
                      <span class="badge badge-danger"> {{$order->status}} </span>
                      @endif
                  </td>
                  <td class="text-center">{{$order->address}}</td>
                  <td class="text-center">{{$order->customer_note}}</td>
                </tr>
                <tr>   {{-- order items --}}
                    <th>
                        Product
                    </th>
                    <th style="font-weight: bold" class="text-center">
                        Quantity
                    </th>
                    <th style="font-weight: bold" class="text-center">
                        Price
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                </tr>
                @foreach($order_items as $item)
                    <tr>
                        <td>
                            {{$item->product->name_en}}
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            @if($item->product->unit == 'gram')
                                {{$item->quantity / 1000}} K.G
                            @elseif($item->product->unit == 'piece')
                                {{$item->quantity}}
                            @endif
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            @if($item->product->unit == 'gram')
                                {{$item->quantity * $item->price / 1000}}
                            @elseif($item->product->unit == 'piece')
                                {{$item->quantity * $item->price}}
                            @endif
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                @endforeach
                    @if(!$order->store)  {{-- الطلب غير محول بعد --}}
                     <tr>
                        <td style="color: #dd2222; font-weight: bold;">
                            Transfer the order to
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            <select class="form-control">
                                @foreach($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name_en}}</option>
                                @endforeach
                        </select>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                              <button class="btn btn-primary">confirm transfer</button>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                    @else  {{-- الطلب محول  --}}
                      <tr>
                        <td style="color: #38b818; font-weight: bold;">
                            Order in 
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            <select class="form-control">
                                @foreach($stores as $store)
                                    @if($order->store_id == $store->id)
                                    <option value="{{$store->id}}" selected>{{$store->name_en}}</option>
                                    @else
                                    <option value="{{$store->id}}">{{$store->name_en}}</option>
                                    @endif
                                @endforeach
                        </select>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                              <button class="btn btn-primary">confirm transfer</button>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                      </tr>
                    @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection