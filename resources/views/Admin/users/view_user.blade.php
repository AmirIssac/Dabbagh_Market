@extends('Layouts.dashboard_main')
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Profile</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="row">
              <div class="col-md-5 pr-1">
                <div class="form-group">
                  <label>Store</label>
                  <input type="text" class="form-control" disabled="" placeholder="Company" value="Creative Code Inc.">
                </div>
              </div>
              <div class="col-md-3 px-1">
                <div class="form-group">
                  <label>Role</label>
                  <input type="text" class="form-control" disabled="" placeholder="Username" value="{{$person->getRoleNames()->first()}}">
                </div>
              </div>
              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" value="{{$person->email}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" placeholder="Company" value="{{$person->profile->first_name}}">
                </div>
              </div>
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" class="form-control" placeholder="Last Name" value="{{$person->profile->last_name}}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" placeholder="Home Address" value="{{$person->profile->address_address}}">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-user">
        <div class="image">
        </div>
        <div class="card-body">
          <div class="author">
            <a href="#">
              <img class="avatar border-gray" src="{{asset('dashboard_asset/img/default-avatar.png')}}" alt="...">
              <h5 class="title">{{$person->name}}</h5>
            </a>
          </div>
          
        </div>
        <hr>
        
      </div>
    </div>
  </div>
</div>
@endsection