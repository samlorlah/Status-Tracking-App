@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Code</th>
                <th>Amount</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="tbody">
              @foreach($products as $product)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->code }}</td>
                  <td>{{ $product->currency }} {{ number_format($product->amount) }}</td>
                  <td>
                    <button type="button" title="View Status" data-toggle="modal" data-target="#modal-view-status-{{ $product->id }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                    {{-- <a href="{{ route('admin.products.status-grid', $product->id) }}" title="Status Grid" class="btn btn-sm btn-info"><i class="fas fa-percent"></i></a> --}}
                    <button onclick="deleteProduct('{{ $product->id }}')" title="Delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    <form id="delete_product_{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="POST">@csrf</form>
                    <div class="modal fade" id="modal-view-status-{{ $product->id }}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">{{ $product->name }}'s Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>S/N</th>
                                  <th>Name</th>
                                  <th>Percentage</th>
                                  <th>Priority</th>
                                  <th>Turn Around Time</th>
                                  <th>Send Notification To Client</th>
                                </tr>
                              </thead>
                              <tbody id="tbody" class="statusTbody">
                                @php
                                  $percent = 0;
                                @endphp
                                @foreach($product->statuses as $status)
                                @php
                                  $percent += $status->percent;
                                @endphp
                                <tr>
                                  <td>{{ $loop->index + 1 }}</td>
                                  <td>{{ $status->name }}</td>
                                  <td>{{ $percent }} %</td>
                                  <td>{{ $status->priority }}</td>
                                  <td>{{ $status->tat }} minutes</td>
                                  <td>
                                    <div class="form-group">
                                      <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" data-id={{ $status->id }} @if($status->send_notification) checked @endif class="custom-control-input send-notification" id="customSwitch3">
                                        <label class="custom-control-label" for="customSwitch3"></label>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <div class="modal-footer justify-content-between">
                            {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    function deleteProduct(id) {
      let conf = confirm('Are you sure you want to delete this product?');
      if(conf) {
        $('#delete_product_' + id).submit();
      }
    }

    $('.statusTbody').delegate('.send-notification', 'change', function() {
      console.log($(this));
    })
  </script>
@endsection