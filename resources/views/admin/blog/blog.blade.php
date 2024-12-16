@extends('admin.master')

@section('title')
     Blogs
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Blogs Details</h6>
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#AddNew" data-whatever="@getbootstrap">Add New</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Image</th>
                            <th>Blog Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($blogs->isNotEmpty())
                        @foreach ($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset($blog->image) }}" width="100px" height="100px"></td>
                            <td>{{ $blog->title }}</td>
                            <td>{!! \Illuminate\Support\Str::words($blog->desc, 30, '...') !!}</td>
                            <td>
                                @if ($blog->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCategoryModal_{{ $blog->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No blogs Found !</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New blog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" id="recipient-name" placeholder="Blog Title">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Blog Description</label>
                                    <textarea name="desc" class="form-control rich-text-editor"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Upload Blog Image <span style="font-size: 12px ; color: red;">(Image Size: 884*644 px )</span></label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
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
        @if(isset($blog))
        @foreach($blogs as $blog)
         <div class="modal fade" id="EditCategoryModal_{{ $blog->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <!-- Modal content goes here, make sure to customize it for each category -->
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         Edit blog
                     </div>
                     <div class="modal-body">
                         <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                             @csrf
                             @method('PUT')
                                <div class="form-group">
                                    <label class="col-form-label">Blog Title</label>
                                    <input type="text" class="form-control" name="title" id="recipient-name" value="{{  $blog->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Blog Description</label>
                                    <textarea name="desc" class="form-control rich-text-editor">{!! $blog->desc !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Upload Blog Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    <img src="{{ asset($blog->image) }}" class="mt-2" width="100px" height="100px">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Blog Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ $blog->status == 1 ? 'selected' : '' }}> Active </option>
                                        <option value="2" {{ $blog->status == 2 ? 'selected' : '' }}> Inactive </option>
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
<script src="https://cdn.tiny.cloud/1/6r8bqrk441b4z3qfz0qimxw6e2oord2ub30is6kcao1xm10c/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '.rich-text-editor',
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
</script>
@endsection
