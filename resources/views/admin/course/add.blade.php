@extends('admin.master')

@section('title')
    Add Courses
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
            <h6 class="m-0 font-weight-bold text-primary mb-3">Add Courses Details</h6>
            <a class="btn btn-primary text-white" href="{{ route('admin.course') }}">Back</a>
        </div>
        <div class="card-body">
            <form id="courseForm" enctype="multipart/form-data">
                @csrf
                <!-- Course Image -->
                <div class="form-group">
                    <label for="courseImage">Course Image * <span style="font-size: 12px ; color: red;">(Image Size: 981*750 px )</span> </label>
                    <input type="file" name="image" class="form-control" required accept="image/*">
                </div>

                <!-- Course Category -->
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price*</label>
                    <input type="number" name="price" class="form-control">
                </div>
                <!-- Sale Price -->
                <div class="form-group">
                    <label for="salePrice">Discount Price</label>
                    <input type="number" name="sale_price" class="form-control">
                </div>

                <!-- Course Title -->
                <div class="form-group">
                    <label for="title">Course Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <!-- Course Description with Rich Text Editor -->
                <div class="form-group">
                    <label for="desc">Course Description</label>
                    <textarea name="desc" class="form-control rich-text-editor"></textarea>
                </div>

                <!-- Tags -->
                <div class="form-group">
                    <label for="tags">Tags</label>
                    <input type="text" name="tags" class="form-control" placeholder="e.g. PHP, Laravel, Backend">
                </div>

                <h3 class="py-4">Modules</h3>
                <!-- Dynamic Modules Section -->
                <div id="modulesContainer"></div>

                <!-- Button to Add Module -->
                <button type="button" id="addModuleButton" class="btn btn-primary">Add Module</button>

                <br><br>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success">Save Course</button>
            </form>
        </div>
    </div>

<div id="videoProgressModal" style="display:none;">
    <div class="videoprogressaddadmin">
        <h4>Course saving is in progress...</h4>
        <div class="progress">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;">
                0%
            </div>
        </div>
        {{-- <p id="progressStatus">Starting encryption...</p> --}}
    </div>
</div>

@endsection

@section('customjs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let moduleIndex = 0;

        // Function to dynamically add a module
        $('#addModuleButton').click(function() {
            $('#modulesContainer').append(`
                <div class="card card-body mb-3 module-section" id="module-${moduleIndex}">
                    <h4>Module ${moduleIndex + 1}</h4>
                    <div class="form-group">
                        <label for="modules[${moduleIndex}][name]">Module Name*</label>
                        <input type="text" name="modules[${moduleIndex}][name]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="modules[${moduleIndex}][desc]">Module Description</label>
                        <textarea name="modules[${moduleIndex}][desc]" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modules[${moduleIndex}][video]">Module Video* <span style="font-size: 12px ; color: red;">( Please upload landscape videos. Portrait videos are not supported! )</span> </label>
                        <input type="file" name="modules[${moduleIndex}][video]" class="form-control" accept="video/mp4,video/x-m4v,video/*">
                    </div>
                    <div class="form-group">
                        <label for="modules[${moduleIndex}][pdf]">Module PDF (Optional)</label>
                        <input type="file" name="modules[${moduleIndex}][pdf][]" class="form-control" accept="application/pdf" multiple>
                    </div>
                    <button type="button" class="btn btn-danger removeModule" data-id="module-${moduleIndex}">Remove Module</button>
                    <hr>
                </div>
            `);
            moduleIndex++;
        });

        // Function to remove a module
        $(document).on('click', '.removeModule', function() {
            const moduleId = $(this).data('id');
            $(`#${moduleId}`).remove();
        });
    });
</script>

<!-- Add rich text editor (e.g., TinyMCE or CKEditor) -->
<script src="https://cdn.tiny.cloud/1/6r8bqrk441b4z3qfz0qimxw6e2oord2ub30is6kcao1xm10c/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '.rich-text-editor',
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
    });
</script>


<script>
$('#courseForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Clear any previous Toastr errors
    toastr.clear();

    // Show the progress modal
    $('#videoProgressModal').show();
    let progress = 0;

    // Simulate progress bar updates
    let interval = setInterval(function() {
        // Increase progress
        if (progress < 90) { // Cap progress at 90% until encryption completes
            progress += 5;
            $('#progressBar').css('width', progress + '%').text(progress + '%');
        }
    }, 1000); // Simulate progress every 1 second

    let formData = new FormData(this);

    // Send AJAX request to the server
    $.ajax({
        url: '{{ route('courses.store') }}', // Your store route
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            clearInterval(interval); // Clear the interval on success
            $('#progressBar').css('width', '100%').text('100%');
            $('#progressStatus').text('Encryption complete.');

            // Hide progress modal and show success message
            setTimeout(function() {
                $('#videoProgressModal').hide();
                toastr.success('Course and modules saved successfully!');

                // Optionally redirect after success
                window.location.href = "{{ route('admin.course') }}";
            }, 1000); // Give a short delay to show the 100% progress
        },
        error: function(xhr) {
            clearInterval(interval); // Clear the interval on error
            $('#progressBar').css('width', '0%').text('0%');
            $('#progressStatus').text('An error occurred during encryption.');

            $('#videoProgressModal').hide(); // Hide progress modal

            if (xhr.status === 422) {
                // Validation errors, show using Toastr
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        toastr.error(errors[key][0]); // Display first error for each field
                    }
                }
            } else {
                toastr.error('An error occurred. Please try again.');
            }
        }
    });
});


</script>

@endsection
