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
                            <div class="col-6">
                                <div class="form-group position-relative">
                                    <label class="form-label">Password: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('password') }}" id="password" class="form-control" name="password" placeholder="Enter password" required="" type="password">
                                    <i class="bi bi-eye-slash position-absolute" id="togglePassword" onclick="showPassword()"></i>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Currency <span class="tx-danger">*</span></label>
                                    <select name="currency" id="currency" required class="form-control paintProtectionFil select2">
                                        <option value="USD">US Dollar (USD)</option>
                                        <option value="EUR">Euro (EUR)</option>
                                        <option value="JPY">Japanese Yen (JPY)</option>
                                        <option value="GBP">British Pound (GBP)</option>
                                        <option value="AUD">Australian Dollar (AUD)</option>
                                        <option value="CAD">Canadian Dollar (CAD)</option>
                                        <option value="CHF">Swiss Franc (CHF)</option>
                                        <option value="CNY">Chinese Yuan (CNY)</option>
                                        <option value="SEK">Swedish Krona (SEK)</option>
                                        <option value="NZD">New Zealand Dollar (NZD)</option>
                                        <option value="MXN">Mexican Peso (MXN)</option>
                                        <option value="SGD">Singapore Dollar (SGD)</option>
                                        <option value="HKD">Hong Kong Dollar (HKD)</option>
                                        <option value="NOK">Norwegian Krone (NOK)</option>
                                        <option value="KRW">South Korean Won (KRW)</option>
                                        <option value="TRY">Turkish Lira (TRY)</option>
                                        <option value="INR">Indian Rupee (INR)</option>
                                        <option value="RUB">Russian Ruble (RUB)</option>
                                        <option value="BRL">Brazilian Real (BRL)</option>
                                        <option value="ZAR">South African Rand (ZAR)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Language <span class="tx-danger">*</span></label>
                                    <select name="language" id="language" required class="form-control paintProtectionFil select2">
                                        <option value="en">English</option>
                                        <option value="zh">Chinese</option>
                                        <option value="es">Spanish</option>
                                        <option value="hi">Hindi</option>
                                        <option value="ar">Arabic</option>
                                        <option value="bn">Bengali</option>
                                        <option value="pt">Portuguese</option>
                                        <option value="ru">Russian</option>
                                        <option value="ja">Japanese</option>
                                        <option value="de">German</option>
                                        <option value="fr">French</option>
                                        <option value="ko">Korean</option>
                                        <option value="it">Italian</option>
                                        <option value="ta">Tamil</option>
                                        <option value="te">Telugu</option>
                                        <option value="vi">Vietnamese</option>
                                        <option value="ur">Urdu</option>
                                        <option value="tr">Turkish</option>
                                        <option value="fa">Persian</option>
                                        <option value="pl">Polish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Company Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('company_name') }}" class="form-control" name="company_name" placeholder="Company name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Custom test: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('custom_text') }}" class="form-control" name="custom_text" placeholder="Custom text" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                <br>
                                <div class="color-picker-container">
                                    <input type="color" id="colorPicker" name="colorPicker"  value="#ff0000">
                                    <input type="text" id="hex" name="hex" required="" value="#ff0000" maxlength="7">
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
                                    Recommended dimensions: 1000x500 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Detailing Decal: <span class="tx-danger">*</span></label>
                                <input type="file" name="detailing_decal" value="{{ old('detailing_decal') }}" id="detailingdecal" class="dropify" data-height="200" required />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1000x500 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-control-label">Videos: <span class="tx-danger">*</span></label>
                                <input type="file" name="video" value="{{ old('video') }}"  id="browseFile" class="dropify" data-height="200"   accept="video/*" />
                                <div id="message"></div>
                            </div>

                            <div class="card-body">
                                <div  style="display: none" class="progress mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                </div>
                            </div>
                            <div class="card-footer p-4" style="display: none">
                                <video id="videoPreview" src="" controls style="width: 100%; height: 600px"></video>
                            </div>
                            <input type="hidden" name="video_path" id="videoPath">
                            <input type="hidden" name="video_filename" id="videoFilename">
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
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    let browseFile = $('#browseFile');
    let resumable = new Resumable({
        target: '{{ route('dashboard.upload') }}',
        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: ['mp4'],
        chunkSize: 10*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('#videoPath').val(response.path_without_storage); // Set the video path in the hidden input
        $('#videoFilename').val(response.filename); // Set the video filename in the hidden input
        $('.card-footer').show();
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    let progress = $('.progress');
    function showProgress() {
        progress.find('.progress-bar').css('width', '0%');
        progress.find('.progress-bar').html('0%');
        progress.find('.progress-bar').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
    }
</script>
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