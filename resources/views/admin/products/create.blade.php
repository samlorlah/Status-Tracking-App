@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name">
              </div>
              <div class="form-group">
                <label>Product Code</label>
                <input type="text" name="code" class="form-control" placeholder="Enter product name">
              </div>
              <div class="form-group">
                <label>Currency</label>
                <select name="currency" class="form-control">
                  <option value="">Select One</option>
                  <option value="USD">US Dollars</option>
                  <option value="NGN">Naira</option>
                </select>
              </div>
              <div class="form-group">
                <label>Product Amount</label>
                <input type="text" name="amount" class="form-control" placeholder="Enter product name">
              </div>
            </div>
            <!-- /.card-body -->

            <div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
@endsection