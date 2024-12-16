@extends('admin.master')

@section('title')
Payment Methods
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Payment Methods Details</h6>
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#AddNew" data-whatever="@getbootstrap">Add New</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Payment Method Name</th>
                            <th>Payment Method Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($payments->isNotEmpty())
                        @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->name }}</td>
                            <td>{{ $payment->number }}</td>
                            <td>
                                @if ($payment->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCategoryModal_{{ $payment->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No payments Found !</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="recipient-name" placeholder="Payment Method Name">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="number" id="recipient-name" placeholder="Payment Method Number">
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
        @if(isset($payment))
        @foreach($payments as $payment)
         <div class="modal fade" id="EditCategoryModal_{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <!-- Modal content goes here, make sure to customize it for each category -->
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         Edit Payment Method
                     </div>
                     <div class="modal-body">
                         <form action="{{ route('payment.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                             @csrf
                             @method('PUT')
                                <div class="form-group">
                                    <label class="col-form-label">Payment Method Name</label>
                                    <input type="text" class="form-control" name="name" id="recipient-name" value="{{  $payment->name }}">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Payment Method Number</label>
                                    <input type="number" class="form-control" name="number" id="recipient-name" value="{{  $payment->number }}">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ $payment->status == 1 ? 'selected' : '' }}> Active </option>
                                        <option value="2" {{ $payment->status == 2 ? 'selected' : '' }}> Inactive </option>
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
