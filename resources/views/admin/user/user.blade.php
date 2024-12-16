@extends('admin.master')

@section('title')
     users
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">User Profile Details</h6>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isNotEmpty())
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->number }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    @if ($user->status == 0)
                                        <a class="btn btn-sm btn-danger" href="{{ route('userStatusChange',$user->id) }}" onclick="return confirm('Are you sure you want to block this profile?');"> Block </a>
                                    @else
                                    <a class="btn btn-sm btn-success" href="{{ route('userStatusChange',$user->id) }}" onclick="return confirm('Are you sure you want to unblock this profile?');"> Unblock </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No Users Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
