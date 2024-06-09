@extends('dashboard.layouts.master')

@section('title', 'Create User')

@section('content')

<div class="row row-sm">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert"> There is something wrong
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h3 class="tile-title">{{ __('Create User') }}</h3>
                <form action="{{ route('dashboard.user.store') }}" method="post" id="userForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('email') }}" class="form-control" name="email" placeholder="Enter Email" required="" type="email">
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">User status: <span class="tx-danger">*</span></label>
                                <select name="status" id="status" required class="form-control paintProtectionFil select2" >
                                    <option value="approved">Approved</option>
                                    <option selected value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">User Type: <span class="tx-danger">*</span></label>
                                    <select name="type" id="type" required class="form-control paintProtectionFil select2" >
                                        <option value="super_admin">Super admin</option>
                                        <option selected value="subscriber">Subscriber</option>
                                    </select>
                                </div>
                            </div>
                        
                         
                            <div class="col-12">
                                <div class="form-group position-relative">
                                    <label class="form-label">Password: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('password') }}" id="password" class="form-control" name="password" placeholder="Enter password" required="" type="password">
                                    <i class="bi bi-eye-slash position-absolute" id="togglePassword" onclick="showPassword()"></i>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Company Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="company_logo" value="{{ old('company_logo') }}" id="companylogo" class="dropify" data-height="200" required />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1080x1080 or 2048x2048 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Decal Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="decal_logo" value="{{ old('decal_logo') }}" id="decallogo" class="dropify" data-height="200" required />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 2048x557 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-control-label">Videos: <span class="tx-danger">*</span></label>
                                <input type="file" name="video" value="{{ old('video') }}" id="video" class="dropify" data-height="200" required  accept="video/*" />
                                <div id="message"></div>
                            </div>
                        </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" id="submit" class="button btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.user.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

<script>
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    

    // document.getElementById('file').addEventListener('change', function(event) {
    //     event.preventDefault(); // Prevent the form from submitting the traditional way
    //     var fileInput = document.getElementById('video');
    //     var file = fileInput.files[0];

    //     if (file) {
    //         var formData = new FormData();
    //         formData.append('file', file);

    //         var xhr = new XMLHttpRequest();
    //         var submitButton = document.getElementById('submit');
    //         var messageDiv = document.getElementById('message');

    //         // Disable the submit button while uploading
    //         submitButton.disabled = true;

    //         // Show a loading message
    //         messageDiv.textContent = 'Uploading...';

    //         // Set up a handler for when the request finishes
    //         xhr.onload = function() {
    //             if (xhr.status === 200) {
    //                 // Upload complete
    //                 messageDiv.textContent = 'Upload complete!';
    //             } else {
    //                 // Error occurred
    //                 messageDiv.textContent = 'Upload failed. Please try again.';
    //             }

    //             // Re-enable the submit button
    //             submitButton.disabled = false;
    //         };

    //         // Open the connection and send the formData
    //         xhr.open('POST', '/upload-endpoint', true);
    //         xhr.send(formData);
    //     } else {
    //         messageDiv.textContent = 'Please select a file to upload.';
    //     }
    // });
</script>

@endsection