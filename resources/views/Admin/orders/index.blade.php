@extends('Layouts.dashboard_main')
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
  <div class="row">
    <div class="col-md-8 ml-auto mr-auto">
      <div class="card card-upgrade">
        <div class="card-header text-center">
          <h4 class="card-title">All orders <span class="badge badge-success">{{$orders->count()}}</span></h3>
            <p class="card-category"></p>
        </div>
        <div class="card-body">
          <div class="table-responsive table-upgrade">
            <table class="table">
              <thead>
                <th>Order number</th>
                <th class="text-center">Price</th>
                <th class="text-center">Status</th>
                <th class="text-center">Details</th>
              </thead>
              <tbody>
                <tr>
                @if( $orders->count() > 0 )
                @foreach($orders as $order)
                  <td>{{$order->number}}</td>
                  <td class="text-center">{{$order->total}}</td>
                  <td class="text-center">{{$order->status}}</td>
                  <td class="text-center"></td>
                @endforeach
                @else
                <td><span class="badge badge-danger">no orders</span></td>
                <td class="text-center"><span class="badge badge-danger">none</span></td>
                <td class="text-center"><span class="badge badge-danger">none</span></td>
                <td class="text-center"><span class="badge badge-danger">none</span></td>
                @endif
                </tr>
              </tbody>
            </table>
            {{ $orders->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection