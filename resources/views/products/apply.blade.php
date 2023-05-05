@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('user.submit-application') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div>
                @if(count($errors) > 0)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                    @endforeach
                @endif
            </div>
              <div class="form-group">
                <label for="">Passport Photograph</label>
                <div class="input-group mb-3">
                  <input type="file" name="passport" required class="form-control" placeholder="Passport Photograph">
                </div>
              </div>
              <div class="form-group">
                <label>ID Card Type</label>
                <select required name="id_type" class="form-control">
                  <option value="">Select One</option>
                  <option value="International Passport">International Passport</option>
                  <option value="Drivers License">Drivers License</option>
                  <option value="BVN">BVN</option>
                </select>
              </div>
              <div class="form-group">
                <label>ID Card Number</label>
                <input type="text" required name="id_number" class="form-control" placeholder="ID Card Number">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Issue Date:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" name="issue_date" required class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Expiry Date:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" name="expiry_date" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">ID Card</label>
                <div class="input-group mb-3">
                  <input type="file" name="id_card" required class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label>No of Dependants</label>
                <div class="input-group mb-3">
                    <select name="dependants" required class="form-control" aria-placeholder="No of Dependants">
                        <option value="">No of Dependants</option>
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                </div>
              </div>
              <div class="form-group mb-3">
                <label>Programme of Choice</label>
                  <select id="product" name="program" required class="form-control" aria-placeholder="Program of Choice">
                      <option value="">Program of Choice</option>
                      @foreach(\App\Models\PackageCategories::orderBy('name')->get() as $product)
                          <option value="{{ $product->id }}" data-id="{{ $product->id }}">{{ $product->name }}</option>
                      @endforeach
                    </select>
              </div>
              <div class="form-group mb-3">
                <label>Total Amount Due</label>
                <div class="input-group">
                    <input type="text" id="amount" name="amount" readonly required class="form-control" placeholder="Amount">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-cash"></span>
                      </div>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label>Residential Address</label>
                <textarea rows="5" required name="residential_address" class="form-control" placeholder="Residential Address"></textarea>
              </div>
            <div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
@endsection
@section('script')
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script>
    $.ajaxSetup({
      headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      }
    });

    $('.datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    let product = document.getElementById('product');
    product.addEventListener('change', function () {
      let id = product.value;
      $.ajax({
        type: "GET",
        url: $('#base_url').val() + '/fetch-product/' + id,
        success: function (res) {
          let amount = document.getElementById('amount');
          amount.value = `${res.product.currency} ${res.product.amount}`
        },
        error: function (err) {
          console.log(err);
        }
      })
    });
  </script>
@endsection