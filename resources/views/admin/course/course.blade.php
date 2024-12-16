@extends('admin.master')

@section('title')
     Courses
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Courses Details</h6>
            <a class="btn btn-primary text-white" href="{{ route('admin.addcourse') }}">Add New</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Modules</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($courses->isNotEmpty())
                        @foreach ($courses as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset($course->image) }}" width="100px" height="100px"></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->category->name }}</td>
                            <td>{{ $course->modules->count() }}</td>
                            <td>{{ isset($course->sale_price) ? $course->sale_price : $course->price }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.editcourse', $course->id) }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                    <form action="{{ route('courseDelete', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No courses Found !</td>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>


@endsection
