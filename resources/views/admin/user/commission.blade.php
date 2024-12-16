@extends('admin.master')

@section('title')
     Affilaite Users Commission
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Affilaite Users Commission Details</h6>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Total Uses of Coupon</th>
                            <th>Total Commisson</th>
                            <th>Payment Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if ($user->coupon !== null)
                                    {{ $orders->where('coupon_id' , $user->coupon->id )->count() > 0 ? $orders->where('coupon_id' , $user->coupon->id )->count() : 0 }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if ($user->coupon !== null)
                                    {{ $orders->where('coupon_id' , $user->coupon->id )->sum('commission') > 0 ? $orders->where('coupon_id' , $user->coupon->id )->sum('commission') : 0 }}
                                @else
                                    0
                                @endif

                            </td>
                            <td>{{ $user->commission > 0 ? $user->commission : 'No Pending Ammount' }}</td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No Affiliate Commission Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
