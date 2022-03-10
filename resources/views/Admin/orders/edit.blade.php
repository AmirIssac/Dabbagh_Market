@extends('Layouts.dashboard_main')
@section('links')
<style>
    .pending-row{
        background-color: #cfccca;
    }
    .preparing-row{
        background-color: #04558b;
        color: white;
    }
    .shipping-row{
        background-color: #409ad6;
    }
    .delivered-row{
        background-color: #38b818;
        color: white;
    }
    .rejected-row{
        background-color: #c00202;
        color: white;
    }
</style>
@endsection
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
                <th style="font-weight: bold" class="text-center">Status</th>
                <th style="font-weight: bold" class="text-center">Total</th>
                <th style="font-weight: bold" class="text-center">Address</th>
                <th style="font-weight: bold" class="text-center">Payment</th>
                <th style="font-weight: bold" class="text-center">Payment status</th>
                <th style="font-weight: bold" class="text-center">Note</th>
              </thead>
              <tbody>
                <tr style="font-weight: bold">
                  <td>
                    @if($order->user->isGuest())
                    Guest
                    @else
                    {{$order->user->profile->first_name}}
                    @endif
                  </td>
                  <td class="text-center">
                    @if($order->status == 'pending')
                    <b style="color: #ff7300"> {{$order->status}} </b>
                    @elseif($order->status == 'preparing' || $order->status == 'shipping')
                    <b style="color: #04558b"> {{$order->status}} </b>
                    @elseif($order->status == 'delivered')
                    <b style="color: #069e1f"> {{$order->status}} </b>
                    @elseif($order->status == 'failed' || $order->status == 'cancelled' || $order->status == 'rejected')
                    <b style="color: #c00202"> {{$order->status}} </b>
                    @endif
                </td>
                  <td style="font-weight: bold; color: #38b818;" class="text-center">{{$order->total}}</td>
                  <td class="text-center">{{$order->address}}</td>
                  <td class="text-center">{{$order->paymentDetail->provider}}</td>
                  <td class="text-center">{{$order->paymentDetail->status}}</td>
                  <td class="text-center">
                    @if($order->customer_note)
                       {{$order->customer_note}}
                    @else
                      <span class="badge badge-danger">NONE</span>
                    @endif
                  </td>
                </tr>
                <tr>   {{-- order items --}}
                    <th>
                      Code
                    </th>
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
                    <th style="font-weight: bold" class="text-center">
                      Total
                    </th>
                    <th>
                    </th>
                </tr>
                @foreach($order_items as $item)
                    <tr>
                        <td>
                          {{$item->product->code}}
                        </td>
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
                        <td style="font-weight: bold; color: #38b818;" class="text-center">
                          @if($loop->last)
                              {{$order->total}}
                          @endif
                        </td>
                    </tr>
                @endforeach
                @if(isset($order_center_system))
                {{-- center transfer process --}}
                <tr class="pending-row">
                      <td>
                          <b>1</b>
                      </td>
                      <td style="font-weight: bold" class="text-center">
                        {{--  {{$order_center_system->status}}  --}}
                        transfered
                      </td>
                      <td style="font-weight: bold" class="text-center">
                          {{$order_center_system->created_at}}
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                      <td>
                      </td>
                 </tr>
                {{-- employee life cycle except center one --}}
                <?php $counter = 2 ; ?>
                @foreach($order_employee_systems as $order_employee_process)
                  @if($order_employee_process->status == 'preparing')
                  <tr class="preparing-row">
                  @elseif($order_employee_process->status == 'shipping')
                  <tr class="shipping-row">
                  @elseif($order_employee_process->status == 'delivered')
                  <tr class="delivered-row">
                  @elseif($order_employee_process->status == 'rejected')
                  <tr class="rejected-row">
                  @endif
                        <td>
                            <b>{{$counter}}</b>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            {{$order_employee_process->status}}
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            {{$order_employee_process->created_at}}
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                   </tr>
                   <?php $counter++; ?>
                   @endforeach
                   @endif
                    @if(!$order->store)  {{-- الطلب غير محول بعد --}}
                    <form action="{{route('transfer.order',$order->id)}}" method="POST">
                      @csrf
                        <tr>
                            <td style="color: #dd2222; font-weight: bold;">
                                Transfer the order to
                            </td>
                            <td style="font-weight: bold" class="text-center">
                                <select name="store_id" class="form-control">
                                    @foreach($stores as $store)
                                        <option value="{{$store->id}}">{{$store->name_en}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                              <input type="text" name="admin_note" class="form-control" placeholder="additional note...">
                            </td>
                            <td style="font-weight: bold" class="text-center">
                              <button type="submit" class="btn btn-primary">confirm transfer</button>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </form>
                    @elseif($order->orderSystems()->count() == 1)  {{-- الطلب محول ولكن لم يستلمه الكاشير بعد --}}
                      <tr>
                        <td style="font-weight: bold;">
                            Order in 
                        </td>
                        <td style="color: #38b818; font-weight: bold;" class="text-center">
                            <b>{{$order_store->name_en}}</b>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                      </tr>
                      <form action="{{route('transfer.order',$order->id)}}" method="POST">
                        @csrf
                        <tr>
                          <td style="color: #dd2222; font-weight: bold;">
                            Change order to
                          </td>
                          <td style="font-weight: bold" class="text-center">
                              <select name="store_id" class="form-control">
                                  @foreach($stores as $store)
                                      @if($order->store_id == $store->id)
                                      <option value="{{$store->id}}" selected>{{$store->name_en}}</option>
                                      @else
                                      <option value="{{$store->id}}">{{$store->name_en}}</option>
                                      @endif
                                  @endforeach
                          </select>
                          <input type="hidden" name="change_order_transfer" value="yes">
                          </td>
                          <td style="font-weight: bold" class="text-center">
                                <button class="btn btn-primary">confirm transfer</button>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                          <td>
                          </td>
                        </tr>
                      </form>
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