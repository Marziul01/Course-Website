@extends('admin.master')

@section('title')
Combo Offers
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Combo Courses Offer</h6>
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#AddNew" data-whatever="@getbootstrap">Add New</a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered userProfiles" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Combo Image</th>
                            <th>Combo Title</th>
                            <th>Combo Courses</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($combos->isNotEmpty())
                        @foreach ($combos as $combo)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset($combo->image) }}" alt=""></td>
                            <td>{{ $combo->title }}</td>
                            <td>
                                @foreach ($combo->comboCourses as $combocoruse)
                                    <p>{{ $combocoruse->course->title }}</p><br>
                                @endforeach
                            </td>
                            <td>
                                <span>{{ $combo->sale_price ?? $combo->price }}</span>
                                @if (isset($combo->sale_price))
                                <span style="text-decoration: line-through;color: red;">{{ $combo->price }}</span>
                                @endif

                            </td>
                            <td>
                                @if ($combo->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center" style="column-gap: 10px">
                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditCategoryModal_{{ $combo->id }}"><i class="bi bi-pen-fill"></i> Edit</a>
                                            <form action="{{ route('comboDestroy', $combo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this combo?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Delete</button>
                                            </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @else
                            <td colspan="7"> No combos Found !</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Combo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('comboStore') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="courses">Upload Combo Course Image* <span style="font-size: 12px ; color: red;">(Image Size: 981*750 px )</span></label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" id="recipient-name" placeholder="Combo Title*">
                            </div>

                            <div class="form-group">
                                <label for="courses">Select Courses*:</label>
                                <select name="courses[]" class="form-control" multiple required>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="price" id="recipient-name" placeholder="Combo Price*">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="sale_price" id="recipient-name" placeholder="Combo Discount Price">
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
        @if(isset($combo))
        @foreach($combos as $combo)
         <div class="modal fade" id="EditCategoryModal_{{ $combo->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <!-- Modal content goes here, make sure to customize it for each category -->
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         Edit combo
                     </div>
                     <div class="modal-body">
                         <form action="{{ route('comboUpdate', $combo->id) }}" method="POST" enctype="multipart/form-data">
                             @csrf
                             <div class="form-group">
                                <label for="courses">Upload Combo Course Image </label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <p class="my-2">Previous Image: </p>
                                <img src="{{ asset($combo->image) }}" alt="">
                            </div>
                                <div class="form-group">
                                    <label class="col-form-label">Combo Title</label>
                                    <input type="text" class="form-control" name="title" id="recipient-name" value="{{  $combo->title }}">
                                </div>

                                <div class="form-group">
                                    <label for="courses">Select Courses:</label>
                                    <select name="courses[]" class="form-control" multiple required>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ $combo->comboCourses->contains('course_id', $course->id) ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label >Combo Price</label>
                                    <input type="number" class="form-control" name="price" id="recipient-name" value="{{ $combo->price }}">
                                </div>
                                <div class="form-group">
                                    <label >Combo Discount Price</label>
                                    <input type="number" class="form-control" name="sale_price" id="recipient-name" value="{{ $combo->sale_price }}">
                                </div>


                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{ $combo->status == 1 ? 'selected' : '' }}> Active </option>
                                        <option value="2" {{ $combo->status == 2 ? 'selected' : '' }}> Inactive </option>
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
