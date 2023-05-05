@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.products.storeClientStatus') }}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Status Name">
              </div>
              <div class="form-group mb-3">
                <label>Programme</label>
                  <select id="product" name="program" required class="form-control" aria-placeholder="Program of Choice">
                      <option value="">Program of Choice</option>
                      @foreach(\App\Models\PackageCategories::orderBy('name')->get() as $product)
                        <option value="{{ $product->id }}" data-id="{{ $product->id }}">{{ $product->name }}</option>
                      @endforeach
                    </select>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select required class="select2 statusList" name="statuses[]" multiple="multiple" data-placeholder="You can select more than one" style="width: 100%;">
                  
                </select>
              </div>
            </div>
            <!-- /.card-body -->

            <div>
              <button type="submit" class="btn btn-primary formSubmitBtn">Submit</button> <br />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
@endsection
@section('script')
  <script>
    $('.select2').select2()
    $('#product').on('change', function() {
      $('.statusList').empty();
      let base_url = $('#base_url').val();
      let id = $(this).val();

      $.ajax({
        url: base_url + '/products/fetch-status/' + id,
        type: 'GET',
        success: function(res) {
          console.log(res);
          $.each(res.statuses, (index, status) => {
            $('.statusList').append(
              `<option value="${status.id}">${status.name}</option>`
            )
          })
        },
        error: function(err) {
          console.log(err);
        },
      })
    })
  </script>
@endsection