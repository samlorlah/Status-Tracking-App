@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Welcome {{ auth()->user()->firstname. ' '. auth()->user()->lastname }}</div>

                <div class="card-body">
                    @php
                        $programs = auth()->user()->programs;
                    @endphp
                    @if(count($programs) < 1)
                        <h3 class="text-danger">You have not applied for any program</h3>
                    @else
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Application Date</th>
                                    <th>Programme of Choice</th>
                                    <th>Amount Due</th>
                                    <th>Amount Paid</th>
                                    <th>Outstanding Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($programs as $program)
                                    <tr>
                                        <td>{{ date('d-m-Y H:i:s') }}</td>
                                        <td>{{ \App\Models\PackageCategories::where('id', $program->product)->first()->name }}</td>
                                        <td>{{ $program->currency. " ". number_format($program->amount_due, 2) }}</td>
                                        <td>{{ $program->currency. " ". number_format($program->amount_paid, 2) }}</td>
                                        <td>{{ $program->currency. " ". number_format($program->outstanding_amount, 2) }}</td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#modal-view-status-{{ $program->id }}" class="btn  btn-primary  btn-sm"><i class="fa fa-eye"></i> View Status</button>
                                            <div class="modal fade" id="modal-view-status-{{ $program->id }}">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <form action="#" method="POST">
                                                      @csrf
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">View Status for Application #{{ $program->id }}</h4>
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
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbody">
                                                                @php
                                                                    $product = App\Models\PackageCategories::where('id', $program->product)->first();
                                                                    $clientStatus = App\Models\ClientProductStatus::where('package_category_id', $product->id)->orderBy('created_at', 'desc')->get();
                                                                    // $statuses = null;
                                                                    // if(count($clientStatus) > 0) {
                                                                    //     foreach()
                                                                    //     $stats = json_decode($clientStatus->statuses, true);
                                                                    //     $statuses = App\Models\ProductStatus::whereIn('id', $stats);
                                                                    // }
                                                                @endphp
                                                                @foreach($clientStatus as $stat)
                                                                    @php
                                                                        $stats = json_decode($stat->statuses, true);
                                                                        $statuses = App\Models\ProductStatus::whereIn('id', $stats);
                                                                        $currentStatus = 0;
                                                                        foreach($stats as $status) {
                                                                            $programStatus = App\Models\ApplicationStatusGrid::where('application_id', $program->id)->where('status_id', $status)->first();
                                                                            if($programStatus && $programStatus->status == 1) {
                                                                                $currentStatus += 1;
                                                                            }
                                                                        }

                                                                        $status = 0;
                                                                        if($currentStatus > 0 && $currentStatus < count($stats)) {
                                                                            $status = 1;
                                                                        } else if($currentStatus > 0 && $currentStatus == count($stats))
                                                                        {
                                                                            $status = 2;
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $stat->name }}</td>
                                                                        <td>{{ $statuses->sum('tat') }} minutes</td>
                                                                        <td>
                                                                            @if($status == 0)
                                                                            Pending
                                                                            @elseif($status == 1)
                                                                            Ongoing
                                                                            @elseif($status == 2)
                                                                            Completed
                                                                            @endif
                                                                        </td>

                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            {{-- <tbody id="tbody">
                                                                @foreach($program->status_grid as $grid)
                                                                    @php
                                                                        $status = \App\Models\ProductStatus::where('id', $grid->status_id)->first();
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $status->name }}</td>
                                                                        <td>{{ $status->name }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody> --}}
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                      {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                                                      <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                                    </div>
                                                  </form>
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
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
