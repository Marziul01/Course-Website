@extends('admin.master')

@section('title')
Canceled orders
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Canceled Orders Details</h6>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>User Name</th>
                            <th>Courses</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            <th>Payment Number</th>
                            <th>Transaction ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isNotEmpty())
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>@foreach ($order->items as $item)
                                @if (isset($item->course))
                                <p>{{ $item->course->title }}</p><br>
                                @else
                                    Course has been deleted
                                @endif
                            @endforeach</td>
                            <td>{{ $order->grand_total }}</td>
                            <td>{{ $order->payment->name }}</td>
                            <td>{{ $order->payment_number }}</td>
                            <td>{{ $order->transaction_id }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-success" href="{{ route('admin.complete.order', $order->id) }}" onclick="return confirm('Are you sure you want to Complete this profile?');"> Complete </a>
                                    <a class="btn btn-sm btn-danger" href="{{ route('admin.delete.order', $order->id) }}" onclick="return confirm('Are you sure you want to Delete this profile?');"> Delete </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No orders Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
