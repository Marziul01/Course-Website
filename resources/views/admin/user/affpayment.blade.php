@extends('admin.master')

@section('title')
     Affilaite Commission Payment Request
@endsection

@section('content')

<div class="container-fluid">
    @include('admin.auth.message')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="alert-ul">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary mb-3">Commission Payment Requests</h6>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Total Commission</th>
                            <th>Total Paid</th>
                            <th>Pending</th>
                            <th>Paid Now</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($requests->isNotEmpty())
                        @foreach ($requests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>
                                @if ($request->user->coupon !== null)
                                    {{ $orders->where('coupon_id' , $request->user->coupon->id )->sum('commission') > 0 ? $orders->where('coupon_id' , $request->user->coupon->id )->sum('commission') : 0 }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                {{ $requests->where('user_id', $request->user->id)->sum('paid') }}
                            </td>
                            <td>{{ $request->user->commission > 0 ? $request->user->commission : 'No Pending Ammount' }}</td>
                            <td>@if($request->status !== 1) {{ $request->paid ?? 0}} @else Didn't paid yet! @endif</td>
                            <td>
                                @if ($request->status == 1)
                                <form action="{{ route('payRequest', $request->id) }}" method="POST" class="d-flex" onsubmit="return confirm('Confirm your Payment?');">
                                    @csrf
                                    <input class="form-control affpaymentinputs" name="paid" type="number" placeholder="Payment Ammount">
                                    <button class="btn btn-sm btn-success" type="submit">PayNow</button>
                                </form>
                                @else
                                <a class="btn btn-sm btn-success" > Paid </a>
                                @endif

                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No Affiliate Payment Requests Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
