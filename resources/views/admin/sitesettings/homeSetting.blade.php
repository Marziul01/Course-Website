@extends('admin.master')

@section('title')
    Home Page Settings
@endsection

@section('content')

    <div class="container-fluid">

        @include('admin.auth.message')
        <div class="row ">
            <div class="col-md-12">
                <form method="post" action="{{ route('admin.homeSettingUpdate') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card m-5" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">Hero Section Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <h4 class="">Image</h4>
                                        <img src="{{ asset($homeSetting->image) }}" class="w-50 py-3">

                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h4>Overview Video</h4>
                                        <video src="{{ asset($homeSetting->video) }}" class="w-50" controls ></video>

                                        <input type="file" name="video" class="form-control" accept="video/*">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Pre Title Text</label>
                                    <input type="text" name="pretitle" class="form-control" value="{{ $homeSetting->pretitle }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $homeSetting->title }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Sub Title</label>
                                    <input type="text" name="subtitle" class="form-control" value="{{ $homeSetting->subtitle }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Point One</label>
                                    <input type="text" name="point_one" class="form-control" value="{{ $homeSetting->point_one }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Two</label>
                                    <input type="text" name="point_two" class="form-control" value="{{ $homeSetting->point_two }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Three</label>
                                    <input type="text" name="point_three" class="form-control" value="{{ $homeSetting->point_three }}">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="post" action="{{ route('admin.homeSettingUpdatetwo') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card m-5" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">Services Section</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Service One</label>
                                    <input type="text" name="service_one" class="form-control" value="{{ $homeSetting->service_one }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Service Two</label>
                                    <input type="text" name="service_two" class="form-control" value="{{ $homeSetting->service_two }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Service Three</label>
                                    <input type="text" name="service_three" class="form-control" value="{{ $homeSetting->service_three }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Service Four</label>
                                    <input type="text" name="service_four" class="form-control" value="{{ $homeSetting->service_four }}">
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label>Service Five</label>
                                    <input type="text" name="service_five" class="form-control" value="{{ $homeSetting->service_five }}">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="post" action="{{ route('admin.homeSettingUpdatethree') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card m-5" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">About Section Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <h4 class="">Image 1</h4>
                                        <img src="{{ asset($homeSetting->aboutimageone) }}" class="w-50 py-3" height="150px">

                                        <input type="file" name="aboutimageone" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h4>Image 2</h4>
                                        <img src="{{ asset($homeSetting->aboutimagetwo) }}" class="w-50 py-3" height="150px">

                                        <input type="file" name="aboutimagetwo" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Pre Title Text</label>
                                    <input type="text" name="aboutpretitle" class="form-control" value="{{ $homeSetting->aboutpretitle }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Title</label>
                                    
                                    <textarea name="abouttitle" class="form-control rich-text-editor"> {!! $homeSetting->abouttitle !!} </textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Sub Title</label>
                                    <textarea name="aboutsubtitle" class="form-control rich-text-editor"> {!! $homeSetting->aboutsubtitle !!} </textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Point One</label>
                                    <input type="text" name="aboutpoint_one" class="form-control" value="{{ $homeSetting->aboutpoint_one }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Two</label>
                                    <input type="text" name="aboutpoint_two" class="form-control" value="{{ $homeSetting->aboutpoint_two }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Three</label>
                                    <input type="text" name="aboutpoint_three" class="form-control" value="{{ $homeSetting->aboutpoint_three }}">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <form method="post" action="{{ route('admin.homeSettingUpdatefour') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card m-5" style="margin-top: 0px !important;">
                        <div class="card-header">
                            <h5 class="text-black">About Section 2 Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <h4 class="">Image</h4>
                                        <img src="{{ asset($homeSetting->abouttwoimageone) }}" class="w-25 py-3">

                                        <input type="file" class="form-control" name="abouttwoimageone" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Pre Title Text</label>
                                    <input type="text" name="abouttwopretitle" class="form-control" value="{{ $homeSetting->abouttwopretitle }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Title</label>
                                    <textarea name="abouttwotitle" class="form-control rich-text-editor"> {!! $homeSetting->abouttwotitle !!} </textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Sub Title</label>
                                    <textarea name="abouttwosubtitle" class="form-control rich-text-editor"> {!! $homeSetting->abouttwosubtitle !!} </textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Point One</label>
                                    <input type="text" name="abouttwopoint_one" class="form-control" value="{{ $homeSetting->abouttwopoint_one }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Two</label>
                                    <input type="text" name="abouttwopoint_two" class="form-control" value="{{ $homeSetting->abouttwopoint_two }}">
                                </div>
                                <div class="col-md-6 py-5">
                                    <label>Point Three</label>
                                    <input type="text" name="abouttwopoint_three" class="form-control" value="{{ $homeSetting->abouttwopoint_three }}">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-25">Save settings</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>


    </div>

<!-- Add rich text editor (e.g., TinyMCE or CKEditor) -->
<script src="https://cdn.tiny.cloud/1/6r8bqrk441b4z3qfz0qimxw6e2oord2ub30is6kcao1xm10c/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '.rich-text-editor',
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
</script>


@endsection
