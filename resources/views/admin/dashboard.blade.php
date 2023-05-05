@extends('admin.layouts.app')

@section('content')
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-6 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ count(App\Models\User::all()) }}</h3>

          <p>Total Registered Users</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-6 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ count(App\Models\ProductApplication::where('status', '>', 1)->get()) }}</h3>

          <p>Applications</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <div class="row">
    <h3>All other overview for admin goes in here</h3>
  </div>
  <!-- /.row (main row) -->
@endsection