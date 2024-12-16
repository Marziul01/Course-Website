@extends('admin.master')

@section('title')
    Edit New Courses
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Edit Course</h6>
            <a class="btn btn-primary text-white" href="{{ route('admin.course') }}">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('courseUpdate', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Course Title -->
                <div class="form-group">
                    <label for="courseTitle">Course Title *</label>
                    <input type="text" class="form-control" name="title" value="{{ $course->title }}">
                </div>

                <!-- Course Category -->
                <div class="form-group">
                    <label for="courseCategory">Course Category *</label>
                    <select class="form-control" name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Image -->
                <div class="form-group">
                    <label for="courseImage">Course Image <span style="font-size: 12px ; color: red;">(Image Size: 981*750 px )</span></label>
                    <input type="file" class="form-control" name="image">
                    <p class="mt-2 mb-2">Previous Image : </p>
                    @if($course->image)
                        <img src="{{ asset($course->image) }}" alt="Course Image" width="150px">
                    @endif
                </div>

                <div class="form-group">
                    <label for="desc">Course Description</label>
                    <textarea name="desc" class="form-control rich-text-editor">{!! $course->desc !!}</textarea>
                </div>

                <div class="form-group">
                    <label for="courseTitle">Price *</label>
                    <input type="text" class="form-control" name="price" value="{{ $course->price }}">
                </div>
                <div class="form-group">
                    <label for="courseTitle">Discount Price</label>
                    <input type="text" class="form-control" name="sale_price" value="{{ $course->sale_price }}">
                </div>
                <div class="form-group">
                    <label for="courseTitle">Course Tags</label>
                    <input type="text" class="form-control" name="tags" value="{{ $course->tags }}">
                </div>


                <h3 class="py-4">Modules</h3>

                <div class="Previous Modules">
                    @foreach($course->modules as $index => $module)
                        <div class="card card-body mb-3 module-card" id="module-{{ $module->id }}">
                            <h4>Previous Module {{ $loop->iteration }}</h4>
                            <input type="hidden" name="premodules[{{ $index }}][id]" value="{{ $module->id }}">

                            <!-- Module Name -->
                            <div class="form-group">
                                <label for="moduleName">Module Name</label>
                                <input type="text" class="form-control" name="premodules[{{ $index }}][name]" value="{{ $module->name }}">
                            </div>

                            <!-- Module Description -->
                            <div class="form-group">
                                <label for="moduleDesc">Module Description</label>
                                <input type="text" class="form-control" name="premodules[{{ $index }}][desc]" value="{{ $module->desc }}">
                            </div>

                            <!-- Module PDFs -->
                            <div class="form-group">
                                <label for="modulePDF">Module PDFs</label>
                                <input type="file" class="form-control" name="premodules[{{ $index }}][pdfs][]" multiple accept="application/pdf">
                                @if($module->pdf)
                                    <p class="mt-2">Previous PDFs:
                                        @foreach(explode(',', $module->pdf) as $pdf)
                                            <a href="{{ asset($pdf) }}" target="_blank">{{ basename($pdf) }}</a>
                                            <input type="hidden" name="premodules[{{ $index }}][old_pdfs][]" value="{{ $pdf }}">
                                            <br>
                                        @endforeach
                                    </p>
                                @endif
                            </div>

                            <!-- Remove Module Button -->
                            <button type="button" class="btn btn-danger remove-premodule" data-id="{{ $module->id }}">Remove Module</button>
                        </div>
                    @endforeach
                </div>
                <!-- Add/Edit Modules -->
                <div id="moduleInputs">

                </div>

                <!-- Button to Add New Modules -->
                <button type="button" id="addModuleBtn" class="btn btn-primary">Add Module</button>

                <button type="submit" class="btn btn-primary">Update Course</button>
            </form>
        </div>
    </div>


@endsection


@section('customjs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.getElementById('addModuleBtn').addEventListener('click', function() {
    const moduleIndex = document.querySelectorAll('.module-group').length;
    const moduleTemplate = `
        <div class="card card-body mb-3 module-group" data-index="${moduleIndex}">
            <h4>New Module ${moduleIndex + 1}</h4>
            <div class="form-group">
                <label for="moduleName">Module Name*</label>
                <input type="text" class="form-control" name="modules[${moduleIndex}][name]" required>
            </div>
            <div class="form-group">
                <label for="moduleDesc">Module Description</label>
                <textarea class="form-control" name="modules[${moduleIndex}][desc]"></textarea>
            </div>

            <div class="form-group">
                <label for="modules[${moduleIndex}][pdf]">Module PDF (Optional)</label>
                <input type="file" name="modules[${moduleIndex}][pdf][]" class="form-control" accept="application/pdf" multiple>
            </div>

            <button type="button" class="btn btn-danger remove-module">Remove Module</button>
        </div>
    `;

    document.getElementById('moduleInputs').insertAdjacentHTML('beforeend', moduleTemplate);
});

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-module')) {
        event.target.closest('.module-group').remove();
    }
});

</script>

<script src="https://cdn.tiny.cloud/1/6r8bqrk441b4z3qfz0qimxw6e2oord2ub30is6kcao1xm10c/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '.rich-text-editor',
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
</script>


<script>
    $(document).on('click', '.remove-premodule', function() {
        var moduleId = $(this).data('id');
        var confirmed = confirm('Are you sure you want to remove this module?');

        if (confirmed) {
            $.ajax({
                url: '{{ route('module.remove') }}', // The route to handle the delete action
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    id: moduleId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the module card from the DOM
                        $('#module-' + moduleId).remove();

                        // Show success message using Toastr
                        toastr.success('Module removed successfully.', 'Success', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000,
                        });
                    }
                },
                error: function(response) {
                    toastr.error('An error occurred while removing the module.', 'Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 3000,
                    });
                }
            });
        }
    });
</script>


@endsection
