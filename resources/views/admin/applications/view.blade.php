@extends('admin.layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>{{ $program->user->firstname . " " . $program->user->lastname }}'s Application</h4>
            </div>
            <div class="card-body">
              @php
                $product = \App\Models\PackageCategories::where('id', $program->product)->first();
              @endphp
              <table class="table table-bordered">
                <tbody id="tbody">
                  <tr>
                    <th>PassportPhotograph</th>
                    <td><img src="{{ asset('passport/'.$program->passport) }}" width="200" height="200" alt=""></td>
                  </tr>
                  <tr>
                    <th>Client Name</th>
                    <td>{{ $program->user->firstname . " " . $program->user->middlename . " " . $program->user->lastname }}</td>
                  </tr>
                  <tr>
                    <th>Client ID Card Type</th>
                    <td>{{ $program->id_type }}</td>
                  </tr>
                  <tr>
                    <th>Client ID Number</th>
                    <td>{{ $program->id_number }}</td>
                  </tr>
                  <tr>
                    <th>Client ID Issue Date / Expiry  Date</th>
                    <td>{{ Carbon\Carbon::parse($program->issue_date)->format('d F Y') }} / {{ Carbon\Carbon::parse($program->expiry_date)->format('d F Y') }}</td>
                  </tr>
                  <tr>
                    <th>Sign Up Date</th>
                    <td>{{ Carbon\Carbon::parse($program->created_at)->format('d F Y, H:i:s') }}</td>
                  </tr>
                  <tr>
                    <th>No of Dependants</th>
                    <td>{{ $program->dependants }}</td>
                  </tr>
                  <tr>
                    <th>Mobile Number</th>
                    <td>{{ $program->user->phone }}</td>
                  </tr>
                  <tr>
                    <th>Email Address</th>
                    <td>{{ $program->user->email }}</td>
                  </tr>
                  <tr>
                    <th>Residential Address</th>
                    <td>{{ $program->residential_address }}</td>
                  </tr>
                  <tr>
                    <th>Program of Choice</th>
                    <td>{{ $product->name }}</td>
                  </tr>
                  <tr>
                    <th>Application Status</th>
                    <td>
                      <div class="row">
                        <div class="col-md-9">
                        <button type="button" data-toggle="modal" data-target="#modal-view-status-{{ $program->id }}" class="btn  btn-primary  btn-sm"><i class="fa fa-eye"></i> View Status</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-change-status">Change Status</button>
                        </div>
                      </div>
                      {{-- Status Modal --}}
                      <div class="modal fade" id="modal-view-status-{{ $program->id }}">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <form action="#" method="POST">
                              @csrf
                            <div class="modal-header">
                              <h4 class="modal-title">Application Status</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                             <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Turn Around Time</th>
                                  <th>Status</th>
                                  <th>Assigned Officer</th>
                                </tr>
                              </thead>
                              <tbody id="tbody">
                                @php
                                  $programStatus = App\Models\ApplicationStatusGrid::where('application_id', $program->id)->orderBy('id', 'desc')->get();
                                @endphp
                                @foreach($programStatus as $status)
                                  @php
                                    $stat = App\Models\ProductStatus::where('id', $status->status_id)->first();
                                  @endphp
                                  <tr>
                                    <td>{{ $stat->name }}</td>
                                    <td>{{ $stat->tat }} minutes</td>
                                    <td>
                                      @if($status->status == 0)
                                      Pending
                                      @else
                                      Completed
                                      @endif
                                    </td>
                                    <td>
                                      @if($status->admin_id)
                                      @php
                                        $admin = App\Models\Admin::where('id', $status->admin_id)->first();
                                      @endphp
                                      {{ $admin->firstname . " " . $admin->lastname }}
                                      @else
                                      Not Assigned Yet
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                             </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                              {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                              <button type="button" data-dismiss="modal" class="btn btn-primary">Close</button>
                            </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <div class="modal fade" id="modal-change-status">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <form action="#" method="POST">
                              @csrf
                            <div class="modal-header">
                              <h4 class="modal-title">Change Status</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                @php
                                  $stat = App\Models\ApplicationStatusGrid::where('application_id', $program->id)->where('status', 0)->take(2)->get();
                                  $current = $stat[0];
                                  $next = $stat[1];
                                @endphp
                                <div class="form-group">
                                  <label>Current Status</label>
                                  <select readonly name="currentstatus" class="form-control">
                                    <option value="{{ $current->id }}">{{ App\Models\ProductStatus::where('id', $current->status_id)->first()->name }}</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label>Next Status</label>
                                  <select readonly name="nextstatus" class="form-control">
                                    <option value="{{ $next->id }}">{{ App\Models\ProductStatus::where('id', $next->status_id)->first()->name }}</option>
                                  </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                              <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Total Amount Due</th>
                    <td>
                      <div class="row">
                        <div class="col-md-9">
                          {{ $program->currency. " ". number_format($program->amount_due, 2) }}
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-payment"><i class="fa fa-plus"></i> Add Payment</button>
                        </div>
                      </div>
                    </td>
                    {{-- Payment Modal --}}
                    <div class="modal fade" id="modal-payment">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="{{ route('admin.applications.updatePayment', $program->id) }}" method="POST">
                            @csrf
                          <div class="modal-header">
                            <h4 class="modal-title">Update Payment</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="exampleSelectRounded0">Total Amount</label>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">{{ $program->currency }}</span>
                                </div>
                                <input type="text" class="form-control" disabled value="{{ number_format($program->amount_due, 2) }}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleSelectRounded0">Total Amount Paid</label>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">{{ $program->currency }}</span>
                                </div>
                                <input type="text" class="form-control" disabled value="{{ number_format($program->amount_paid, 2) }}">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleSelectRounded0">Outstanding Payment</label>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">{{ $program->currency }}</span>
                                </div>
                                <input type="text" class="form-control" disabled value="{{ number_format($program->outstanding_payment, 2) }}">
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-primary">Update Status</button>
                          </div>
                        </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  </tr>
                  <tr>
                    <th>Amount Paid</th>
                    <td>{{ $program->currency. " ". number_format($program->amount_paid, 2) }}</td>
                  </tr>
                  <tr>
                    <th>Outstanding Payment</th>
                    <td>{{ $program->currency. " ". number_format($program->outstanding_amount, 2) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection