@extends('admin.master')

@section('title')
coupons
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Coupons Details</h6>
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#AddNew" data-whatever="@getbootstrap">Add New</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Coupon</th>
                            <th>Coupon Type</th>
                            <th>Amount</th>
                            <th>Affiliate User</th>
                            <th>Affiliate Commission</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Max User</th>
                            <th>Max Uses Per User</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($coupons->isNotEmpty())
                        @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $coupon->coupon }}</td>
                            <td>{{ $coupon->coupon_type }}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td>{{ $coupon->affiliate_user_id }}</td>
                            <td>{{ $coupon->affiliate_commission ?? 0 }}%</td>
                            <td>{{ $coupon->start_date }}</td>
                            <td>{{ $coupon->expire_date }}</td>
                            <td>{{ $coupon->max_user }}</td>
                            <td>{{ $coupon->uses_per_user }}</td>
                            <td>
                                @if ($coupon->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCategoryModal_{{ $coupon->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No coupons Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="coupon" id="recipient-name" placeholder="Coupon">
                                </div>
                                <div class="form-group">
                                    <select name="type" id="" class="form-control">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="amount" id="recipient-name" placeholder="Coupon Amount">
                                </div>
                                <div class="form-group">
                                    <select name="affiliate_user_id" id="" class="form-control">
                                        <option value="">Select an Affilaite User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="affiliate_commission" id="recipient-name" placeholder="Affiliate Users Commission (Percentage) ">
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-6 form-group">
                                        <label >Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="recipient-name" placeholder="Coupon Start Date">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label >End Date</label>
                                        <input type="date" class="form-control" name="expire_date" id="recipient-name" placeholder="Coupon End Date">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="number" class="form-control" name="max_user" id="recipient-name" placeholder="Maximum User">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="uses_per_user" id="recipient-name" placeholder="Maximum Uses Per User">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option value="1"> Active </option>
                                    </select>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                </form>
            </div>
        </div>
        </div>

        {{--    Edit Category Model--}}
        @if(isset($coupon))
        @foreach($coupons as $coupon)
         <div class="modal fade" id="EditCategoryModal_{{ $coupon->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <!-- Modal content goes here, make sure to customize it for each category -->
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         Edit coupon
                     </div>
                     <div class="modal-body">
                         <form action="{{ route('coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                             @csrf
                             @method('PUT')
                                <div class="form-group">
                                    <label class="col-form-label">Coupon</label>
                                    <input type="text" class="form-control" name="coupon" id="recipient-name" value="{{  $coupon->coupon }}">
                                </div>
                                <div class="form-group">
                                    <label >Coupon Type</label>
                                    <select name="type" id="" class="form-control">
                                        <option value="percentage" {{ $coupon->coupon_type == 'percentage' ? 'selected': '' }} >Percentage</option>
                                        <option value="fixed" {{ $coupon->coupon_type == 'fixed' ? 'selected': '' }}>Fixed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Coupon Amount</label>
                                    <input type="number" class="form-control" name="amount" id="recipient-name" value="{{ $coupon->amount }}">
                                </div>
                                <div class="form-group">
                                    <label >Select an Affilaite User</label>
                                    <select name="affiliate_user_id" id="" class="form-control">
                                        <option value="">Select an Affilaite User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $coupon->affiliate_user_id == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="affiliate_commission" id="recipient-name" value="{{ $coupon->affiliate_commission }}">
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="form-group">
                                        <label >Start Date</label>
                                        <input type="date" class="form-control" name="start_date" id="recipient-name" value="{{  $coupon->start_date }}">
                                    </div>
                                    <div class="form-group">
                                        <label >End Date</label>
                                        <input type="date" class="form-control" name="expire_date" id="recipient-name" value="{{  $coupon->expire_date }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label >Expire Date</label>
                                    <input type="date" class="form-control" name="expire_date" id="recipient-name" value="{{  $coupon->expire_date }}">
                                </div>
                                <div class="form-group">
                                    <label >Maximum User</label>
                                    <input type="number" class="form-control" name="max_user" id="recipient-name" value="{{  $coupon->max_user }}">
                                </div>
                                <div class="form-group">
                                    <label >Maximum Uses Per User </label>
                                    <input type="number" class="form-control" name="uses_per_user" id="recipient-name" value="{{  $coupon->uses_per_user }}">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}> Active </option>
                                        <option value="2" {{ $coupon->status == 2 ? 'selected' : '' }}> Inactive </option>
                                    </select>
                                </div>

                             <button type="submit" class="btn btn-primary">Update</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
        @endforeach
        @endif


@endsection


@section('customjs')

@endsection
