@extends('Layouts.dashboard_main')
@section('links')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .displaynone {
    display: none;
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
        <span id="new-orders-badge" style="margin: 20px;" class="badge badge-success displaynone"><b id="new-orders-count">2</b> NEW</span>
        <div class="card-header text-center">
          <h4 class="card-title">Orders <span class="badge badge-primary"> {{$orders->count()}} </span> </h3>
            <p class="card-category"></p>
        </div>
        <div class="card-body">
          <div class="table-responsive table-upgrade">
            <table class="table">
              <thead>
                <th style="font-weight: bold">Number</th>
                <th style="font-weight: bold" class="text-center">Total</th>
                <th style="font-weight: bold" class="text-center">Status</th>
                <th style="font-weight: bold" class="text-center">Customer</th>
                <th style="font-weight: bold" class="text-center">Store</th>
                <th style="font-weight: bold" class="text-center">Action</th>
              </thead>
              <tbody>
                @foreach($orders as $order)
                <tr style="font-weight: bold">
                  <td>{{$order->number}}</td>
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
                  <td class="text-center">
                    @if($order->user->isGuest())
                    Guest
                    @else
                    {{$order->user->profile->first_name}}
                    @endif
                  </td>
                  <td class="text-center">{{$order->store->name_en}}</td>
                  <td class="text-center"><a href="{{route('employee.edit.order',$order->id)}}"><i class="fas fa-tools"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- timestamp for the last order created when the page refreshed  --}}
<input type="text" id="last-updated-order" value="{{$last_updated_order_timestamp}}">
<button id="test">click</button>
@section('scripts')
<script>
  function checkNewOrders(){
    var token = $("meta[name='csrf-token']").attr("content");
    var updated_at = $('#last-updated-order').val();
    $.ajax(
                {
                    url: "/check/new/orders/",
                    type: 'GET',
                    data: {
                        "_token": token,
                        "updated_at" : updated_at,
                    },
                    success: function (data){
                      if(data > 0){
                        $('#new-orders-badge').removeClass('displaynone');
                        $('#new-orders-count').html(data);
                      }
                    }
    });
  }
  window.setInterval(checkNewOrders, 5000);
</script>
@endsection
@endsection