@extends('dashboard.layouts.master')

@section('title', 'Edit User')

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
                <h3 class="tile-title">{{ __('Edit User') }}</h3>
                <form action="{{ route('dashboard.user.update', $data->id) }}" id="userForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->name }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                                </div>
                            </div>
                            @if(auth()->user()->type === "super_admin")

                            <div class="form-group col-6">
                                <label class="form-label">User status: <span class="tx-danger">*</span></label>
                                <select name="status" id="status" required class="form-control paintProtectionFil select2 select2-no-search" >
                                    <option value="approved" {{ $data->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ $data->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            @endif
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->email }}" class="form-control" name="email" placeholder="Enter Email" required="" type="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Company Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->company_name }}" class="form-control" name="company_name" placeholder="Company name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group position-relative">
                                    <label class="form-label">Password:</label>
                                    <input value="{{ old('password') }}" id="password" class="form-control" name="password" placeholder="Enter password" type="password">
                                    <i class="bi bi-eye-slash position-absolute" id="togglePassword"  onclick="showPassword()"></i>
                                </div>
                            </div>
                           
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Company Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="company_logo" value="{{ old('company_logo') }}" id="company_logo" class="dropify" data-height="200" data-default-file="{{ $companyLogo }}" />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1080x1080 or 2048x2048 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Decal Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="decal_logo" value="{{ old('decal_logo') }}" id="decal_logo" class="dropify" data-height="200" data-default-file="{{ $decalLogo }}" />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1000x500 or 2048x2048 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Detailing Decal: <span class="tx-danger">*</span></label>
                                <input type="file" name="detailing_decal" value="{{ old('detailing_decal') }}" id="detailingdecal" class="dropify" data-height="200" data-default-file="{{ $detailing_decal }}" required />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1000x500 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-control-label">Videos: <span class="tx-danger">*</span></label>
                                <input type="file" name="video" value="{{ old('video') }}" id="browseFile" class="dropify" data-height="200" data-default-file="{{ $video }}" accept="video/*" />
                                <div id="message"></div>
                            </div>
                            <div class="card-body">
                                <div  style="display: none" class="progress mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                                </div>
                            </div>
                            <div class="card-footer p-4" style="display: none">
                                <video id="videoPreview" src="" controls style="width: 100%; height: auto"></video>
                            </div>
                            <input type="hidden" name="video_path" id="videoPath">
                            <input type="hidden" name="video_filename" id="videoFilename">
                        </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" id="submit" class="button btn btn-primary">Save</button>
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

</script>

@endsection