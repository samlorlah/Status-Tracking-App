@extends('admin.layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Application Date</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Programme of Choice</th>
                            <th>Amount Due</th>
                            <th>Amount Paid</th>
                            <th>Outstanding Payment</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach($applications as $program)
                          @php
                            $product = \App\Models\PackageCategories::where('id', $program->product)->first();
                          @endphp
                            <tr>
                                <td>{{ date('d-m-Y H:i:s') }}</td>
                                <td>{{ $program->user->id + 100000 }}</td>
                                <td>{{ $program->user->firstname . ' ' . $program->user->middlename . ' ' .  $program->user->lastname}}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $program->currency. " ". number_format($program->amount_due, 2) }}</td>
                                <td>{{ $program->currency. " ". number_format($program->amount_paid, 2) }}</td>
                                <td>{{ $program->currency. " ". number_format($program->outstanding_amount, 2) }}</td>
                                {{-- <td>
                                  @if($product->code == 'RBI')
                                    @if($program->status == 5) Client Onboarded
                                    @elseif($program->status == 10) Preliminary Documents Submitted
                                    @elseif($program->status == 20) Document Collation in Process
                                    @elseif($program->status == 30) Document Collation in Completed
                                    @elseif($program->status == 40) Matched to Start-up
                                    @elseif($program->status == 45) Incubation Ongoing
                                    @elseif($program->status == 50) Incubation Completed
                                    @elseif($program->status == 55) International Partner Review
                                    @elseif($program->status == 60) Work Permit & PR Submitted
                                    @elseif($program->status == 65) Application Review
                                    @elseif($program->status == 100) PR Approved
                                    @endif
                                  @elseif($product->code == 'CBI')
                                    @if($program->status == 5) Client Onboarded
                                    @elseif($program->status == 10) Document Collation in Process
                                    @elseif($program->status == 25) Document Collation in Completed
                                    @elseif($program->status == 29) Transferred to Internal Audit
                                    @elseif($program->status == 30) Internal Audit Review
                                    @elseif($program->status == 32) Transferred to International Partner
                                    @elseif($program->status == 33) International Partner Review
                                    @elseif($program->status == 35) Bank Clearance
                                    @elseif($program->status == 37) Cleared by Bank
                                    @elseif($program->status == 40) Submitted to CBI Unit
                                    @elseif($program->status == 44) Due Diligence
                                    @elseif($program->status == 46) Submitted to Cabinet
                                    @elseif($program->status == 48) Awaiting Cabinet Decision
                                    @elseif($program->status == 70) Citizenship Approved
                                    @elseif($program->status == 90) Citizenship Certificate Issued
                                    @elseif($program->status == 99) Passport Issued
                                    @elseif($program->status == 100) Passport Delivered to Client
                                    @endif
                                  @endif
                                </td> --}}
                                <td>
                                  <a href="{{ route('admin.applications.view', $program->id) }}" class="btn  btn-primary  btn-sm"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection