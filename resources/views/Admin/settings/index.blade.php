@extends('Layouts.dashboard_main')
@section('links')
<style>
.displaynone{
    display : none;
}
</style>
@endsection
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Settings</h5>
        </div>
        <div class="card-body">
            <form action="{{route('update.settings')}}" method="POST">
                @csrf
            <div class="row">
              <div class="col-md-3 pr-1">
                <div style="display: flex; flex-direction: column;" class="form-group">
                  <label>Tax %</label>
                  <input type="number" name="tax" step="0.5" value="{{$tax}}" class="form-control">
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div style="display: flex; flex-direction: column;" class="form-group">
                  <label>Minimum order limit</label>
                  <input type="number" name="min_order_val" value="{{$min_order}}" class="form-control">
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div style="display: flex; flex-direction: column;" class="form-group">
                  <label>close delivery</label>
                  <input type="time" name="close_delivery_time" value="{{$close_delivery}}" class="form-control">
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div style="display: flex; flex-direction: column;" class="form-group">
                  <label> hours to deliver if we are free </label>
                  <input type="number" name="hours_to_deliver_free" value="{{$hours_deliver_when_free}}" class="form-control">
                </div>
              </div>
              <div class="col-md-3 pr-1">
                <div style="display: flex; flex-direction: column;" class="form-group">
                  <label> number of orders that increase delivery time </label>
                  <input type="number" name="number_of_orders_increase" value="{{$number_of_orders_increase_time}}" class="form-control">
                </div>
              </div>
            </div>
            <button id="edit-user-btn" class="btn btn-primary">Update</button>
            </form>
        </div>
      </div>
    </div>

  </div>
</div>
@section('scripts')

@endsection

@endsection
