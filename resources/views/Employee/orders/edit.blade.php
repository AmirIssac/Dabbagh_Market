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
                <th style="font-weight: bold" class="text-center">Cusomer note</th>
                <th style="font-weight: bold" class="text-center">Center note</th>
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
                  <td class="text-center">{{$order_center_system->employee_note}}</td>
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
                <form action="{{route('employee.change.order.status',$order->id)}}" method="POST">
                    @csrf
                    <tr>
                        <td>
                            <b>Change order status to</b>
                        </td>
                        <td style="font-weight: bold" class="text-center">
                            <select name="order_status" class="form-control">
                                <option value="shipping">shipping</option>
                                <option value="delivered">delivered</option>
                                <option value="rejected">rejected</option>
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection