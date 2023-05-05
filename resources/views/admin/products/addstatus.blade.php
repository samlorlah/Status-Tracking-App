@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.products.storeStatus') }}">
            @csrf
            <div class="card-body">
              <div class="form-group mb-3">
                <label>Programme</label>
                  <select id="product" name="program" required class="form-control" aria-placeholder="Program of Choice">
                      <option value="">Program of Choice</option>
                      @foreach(\App\Models\PackageCategories::orderBy('name')->get() as $product)
                        <option value="{{ $product->id }}" data-id="{{ $product->id }}">{{ $product->name }}</option>
                      @endforeach
                    </select>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Percent - <span id="percentageCont"></span></th>
                    <th>Turn Around Time (TAT in minutes)</th>
                    <th>Priority</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="tbody" class="table-body">
                  <tr>
                    <td><input type="text" required name="name[]" class="form-control" placeholder="Status Name"></td>
                    <td><input type="number" required name="percent[]" class="form-control percent" placeholder="Percentage"></td>
                    <td><input type="number" required name="tat[]" class="form-control" placeholder="Turn Around Time">
                    <td><input type="number" required name="priority[]" class="form-control" placeholder="Priority E.g 0">
                    <td><i class="fa fa-plus text-success" style="cursor: pointer" id="addStatus"></i></td>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

            <div>
              <button type="submit" disabled class="btn btn-primary formSubmitBtn">Submit</button> <br />
              <small class="text-danger percent-danger">Total percentage must be equal to 100</small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  
@endsection
@section('script')
  <script>
    let  addBtn = document.getElementById('addStatus');
    let  tbody = $('.table-body');

    function calculatePercentage() {
      let totalPercent = 0;
      $('.percent').each(function(){
        totalPercent += $(this).val().split(',').join('') - 0
      })

      if(totalPercent === 100) {
        $('.percent-danger').addClass('d-none');
        $('.formSubmitBtn').attr('disabled', false);
      } else {
        $('.percent-danger').removeClass('d-none');
        $('.formSubmitBtn').attr('disabled', true);
      }

      return totalPercent;
    }

    $(document).ready(function(){
      let percent = calculatePercentage();
      $('#percentageCont').html(percent);
    })
    
    addBtn.addEventListener('click', function() {
      let newItem = `
      <tr>
        <td><input type="text" required name="name[]" class="form-control" placeholder="Status Name"></td>
        <td><input type="number" required name="percent[]" class="form-control percent" placeholder="Percentage"></td>
        <td><input type="number" required name="tat[]" class="form-control" placeholder="Turn Around Time">
        <td><input type="number" required name="priority[]" class="form-control" placeholder="Priority E.g 0">
        <td><i class="fa fa-minus text-danger removeStatus" style="cursor: pointer"></i></td>
        </td>
      </tr>
      `
      tbody.append(newItem);
    })

    $('.table-body').delegate('.removeStatus', 'click', function() {
      $(this).closest('tr').remove();
    });

    $('.table-body').delegate('.percent', 'keyup', function() {
      let percent = calculatePercentage();
      $('#percentageCont').html(percent);
    })
  </script>
@endsection