@extends('admin.master')

@section('title')
Admin Profile
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Admin Profile</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.Profilechange') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="recipient-name" placeholder="Your Name" value="{{ Auth::user()->name }}">
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="recipient-name" placeholder="Change Your Email" value="{{ Auth::user()->email }}">
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="recipient-name" placeholder="Change Your Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
            </form>
        </div>
    </div>


@endsection


@section('customjs')

@endsection
