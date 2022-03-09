@extends('Layouts.dashboard_main')
@section('links')
<style>
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
                <th style="font-weight: bold" class="text-center">Cusomer note</th>
                <th style="font-weight: bold" class="text-center">Center note</th>
              </thead>
              <tbody>
                <tr style="font-weight: bold">
                  <td>{{$order->user->profile->first_name}}</td>
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
                  <td style="color:#38b818; font-weight:bold;" class="text-center">{{$order->total}}</td>
                  <td class="text-center">{{$order->address}}</td>
                  <td class="text-center">
                      @if($order->customer_note)
                        {{$order->customer_note}}
                      @else
                        <span class="badge badge-danger">NONE</span>
                      @endif
                  </td>
                  <td class="text-center">
                      @if($order_center_system->employee_note)
                            {{$order_center_system->employee_note}}
                      @else
                            <span class="badge badge-danger">NONE</span>
                      @endif
                  </td>
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
                        <td>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>
                        <b>Transfered by</b>
                    </td>
                    <td style="font-weight: bold" class="text-center">
                        <b>{{$order_center_system->user->name}}</b>
                    </td>
                    <td style="font-weight: bold" class="text-center">
                        To
                    </td>
                    <td style="font-weight: bold" class="text-center">
                        {{$order->store->name_en}}
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                {{-- employee life cycle except center one --}}
                <?php $counter = 1 ; ?>
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
                   </tr>
                   <?php $counter++; ?>
                @endforeach
                @if($order->status == 'pending')
                    <tr>
                        <td>
                            <b>Accept order ?</b>
                        </td>
                        <form action="{{route('employee.accept.order',$order->id)}}" method="POST">
                          @csrf
                            <td style="font-weight: bold" class="text-center">
                            <button type="submit" class="btn btn-success">Accept</button>
                            </td>
                        </form>
                        <td style="font-weight: bold" class="text-center">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                @else
                @if($order->status != 'rejected')
                 <form action="{{route('employee.change.order.status',$order->id)}}" method="POST">
                    @csrf
                    <tr>
                        <td>
                            <b>Change order status to</b>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            <select name="order_status" class="form-control">
                                @if($order->status == 'preparing')
                                    <option value="shipping">shipping</option>
                                    <option value="delivered">delivered</option>
                                    <option value="rejected">rejected</option>
                                @elseif($order->status == 'shipping')
                                    <option value="delivered">delivered</option>
                                    <option value="rejected">rejected</option>
                                @elseif($order->status == 'delivered')
                                    <option value="rejected">rejected</option>
                                @endif
                            </select>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            <button type="submit" class="btn btn-info">Submit</button>
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