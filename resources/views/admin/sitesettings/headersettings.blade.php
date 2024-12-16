@extends('admin.master')

@section('title')
    Site Settings
@endsection

@section('content')

    <div class="container-fluid">

        @include('admin.auth.message')
        <div class="row ">
            <div class="col-md-12">
                <form method="post" action="{{ route('admin.siteSettingUpdate') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siteSettings->id }}">
                    <div class="card m-5" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <h4 class="">Logo</h4>
                                        <p class="py-3">{{ basename($siteSettings->logo) }}</p>

                                        <input type="file" name="logo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h4>Favicon</h4>
                                        <p class="py-3">{{ basename($siteSettings->favicon) }}</p>

                                        <input type="file" name="favicon" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Site Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $siteSettings->title }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Free Course Link</label>
                                    <input type="text" name="free_course" class="form-control" value="{{ $siteSettings->free_course }}">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <form method="post" action="{{ route('admin.siteSettingUpdatetwo') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $siteSettings->id }}">
                    <div class="card m-5">
                        <div class="card-header">
                            <h5 class="text-black">Contact Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $siteSettings->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" value="{{ $siteSettings->address }}">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $siteSettings->email }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Facebook</label>
                                    <input type="text" name="facebook" class="form-control" value="{{ $siteSettings->facebook }}">
                                </div>
                                <div class="col-md-6 ">
                                    <label>Instagram</label>
                                    <input type="text" name="instagram" class="form-control" value="{{ $siteSettings->instagram }}">
                                </div>
                                <div class="col-md-6 ">
                                    <label>Youtube</label>
                                    <input type="text" name="youtube" class="form-control" value="{{ $siteSettings->youtube }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Twitter / X </label>
                                    <input type="text" name="twitter" class="form-control" value="{{ $siteSettings->twitter }}">
                                </div>
                                <div class="col-md-12 " style="padding-bottom: 0px !important;">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>


    </div>

@endsection
