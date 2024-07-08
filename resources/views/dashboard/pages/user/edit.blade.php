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
                    <div id="wizard1">
                        <h3>User Information</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                        <input value="{{ $data->name }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                        <input value="{{ $data->email }}" class="form-control" name="email" placeholder="Enter Email" required="" type="email">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group position-relative">
                                        <label class="form-label">Password: <span class="tx-danger">*</span></label>
                                        <input value="" id="password" class="form-control" name="password" placeholder="Enter password" required="" type="password">
                                        <i class="bi bi-eye-slash position-absolute" id="togglePassword" onclick="showPassword()"></i>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">User status: <span class="tx-danger">*</span></label>
                                    <select name="status" id="status" required class="form-control paintProtectionFil select22" >
                                        <option {{ $data->status == 'approved' ? 'selected' : '' }} value="approved">Approved</option>
                                        <option {{ $data->status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                        <option {{ $data->status == 'rejected' ? 'selected' : '' }} value="rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">User Type: <span class="tx-danger">*</span></label>
                                        <select name="type" id="type" required class="form-control paintProtectionFil select22" >
                                            <option {{ $data->type == 'super_admin' ? 'selected' : '' }} value="super_admin">Super admin</option>
                                            <option {{ $data->type == 'subscriber' ? 'selected' : '' }} value="subscriber">Subscriber</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Currency <span class="tx-danger">*</span></label>
                                        <select name="currency" id="currency" required class="form-control paintProtectionFil select22">
                                            <option {{ $data->currency == 'USD' ? 'selected' : '' }} value="USD">US Dollar (USD)</option>
                                            <option {{ $data->currency == 'EUR' ? 'selected' : '' }} value="EUR">Euro (EUR)</option>
                                            <option {{ $data->currency == 'JPY' ? 'selected' : '' }} value="JPY">Japanese Yen (JPY)</option>
                                            <option {{ $data->currency == 'GBP' ? 'selected' : '' }} value="GBP">British Pound (GBP)</option>
                                            <option {{ $data->currency == 'AUD' ? 'selected' : '' }} value="AUD">Australian Dollar (AUD)</option>
                                            <option {{ $data->currency == 'CAD' ? 'selected' : '' }} value="CAD">Canadian Dollar (CAD)</option>
                                            <option {{ $data->currency == 'CHF' ? 'selected' : '' }} value="CHF">Swiss Franc (CHF)</option>
                                            <option {{ $data->currency == 'CNY' ? 'selected' : '' }} value="CNY">Chinese Yuan (CNY)</option>
                                            <option {{ $data->currency == 'SEK' ? 'selected' : '' }} value="SEK">Swedish Krona (SEK)</option>
                                            <option {{ $data->currency == 'NZD' ? 'selected' : '' }} value="NZD">New Zealand Dollar (NZD)</option>
                                            <option {{ $data->currency == 'MXN' ? 'selected' : '' }} value="MXN">Mexican Peso (MXN)</option>
                                            <option {{ $data->currency == 'SGD' ? 'selected' : '' }} value="SGD">Singapore Dollar (SGD)</option>
                                            <option {{ $data->currency == 'HKD' ? 'selected' : '' }} value="HKD">Hong Kong Dollar (HKD)</option>
                                            <option {{ $data->currency == 'NOK' ? 'selected' : '' }} value="NOK">Norwegian Krone (NOK)</option>
                                            <option {{ $data->currency == 'KRW' ? 'selected' : '' }} value="KRW">South Korean Won (KRW)</option>
                                            <option {{ $data->currency == 'TRY' ? 'selected' : '' }} value="TRY">Turkish Lira (TRY)</option>
                                            <option {{ $data->currency == 'INR' ? 'selected' : '' }} value="INR">Indian Rupee (INR)</option>
                                            <option {{ $data->currency == 'RUB' ? 'selected' : '' }} value="RUB">Russian Ruble (RUB)</option>
                                            <option {{ $data->currency == 'BRL' ? 'selected' : '' }} value="BRL">Brazilian Real (BRL)</option>
                                            <option {{ $data->currency == 'ZAR' ? 'selected' : '' }} value="ZAR">South African Rand (ZAR)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Language <span class="tx-danger">*</span></label>
                                        <select name="language" id="language" required class="form-control paintProtectionFil select22">
                                            <option {{ $data->language == 'en' ? 'selected' : '' }} value="en">English</option>
                                            <option {{ $data->language == 'zh' ? 'selected' : '' }} value="zh">Chinese</option>
                                            <option {{ $data->language == 'es' ? 'selected' : '' }} value="es">Spanish</option>
                                            <option {{ $data->language == 'hi' ? 'selected' : '' }} value="hi">Hindi</option>
                                            <option {{ $data->language == 'ar' ? 'selected' : '' }} value="ar">Arabic</option>
                                            <option {{ $data->language == 'bn' ? 'selected' : '' }} value="bn">Bengali</option>
                                            <option {{ $data->language == 'pt' ? 'selected' : '' }} value="pt">Portuguese</option>
                                            <option {{ $data->language == 'ru' ? 'selected' : '' }} value="ru">Russian</option>
                                            <option {{ $data->language == 'ja' ? 'selected' : '' }} value="ja">Japanese</option>
                                            <option {{ $data->language == 'de' ? 'selected' : '' }} value="de">German</option>
                                            <option {{ $data->language == 'fr' ? 'selected' : '' }} value="fr">French</option>
                                            <option {{ $data->language == 'ko' ? 'selected' : '' }} value="ko">Korean</option>
                                            <option {{ $data->language == 'it' ? 'selected' : '' }} value="it">Italian</option>
                                            <option {{ $data->language == 'it' ? 'selected' : '' }} value="it">Tamil</option>
                                            <option {{ $data->language == 'te' ? 'selected' : '' }} value="te">Telugu</option>
                                            <option {{ $data->language == 'vi' ? 'selected' : '' }} value="vi">Vietnamese</option>
                                            <option {{ $data->language == 'ur' ? 'selected' : '' }} value="ur">Urdu</option>
                                            <option {{ $data->language == 'tr' ? 'selected' : '' }} value="tr">Turkish</option>
                                            <option {{ $data->language == 'fa' ? 'selected' : '' }} value="fa">Persian</option>
                                            <option {{ $data->language == 'pl' ? 'selected' : '' }} value="pl">Polish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Company Name: <span class="tx-danger">*</span></label>
                                        <input value="{{ $data->company_name }}" class="form-control" name="company_name" placeholder="Company name" required="" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Custom test: <span class="tx-danger">*</span></label>
                                        <input value="{{ $data->custom_text }}" class="form-control" name="custom_text" placeholder="Custom text" required="" type="text">
                                    </div>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                    <br>
                                    <div class="color-picker-container">
                                        <input type="color" id="colorPicker" name="colorPicker"  value="{{ $data->hex }}">
                                        <input type="text" id="hex" name="hex" required="" value="{{ $data->hex }}" maxlength="7">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h3>User Media</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-6 mb-2">
                                    <label class="form-control-label">Company Logo: <span class="tx-danger">*</span></label>
                                    <input type="file" name="company_logo" value="" id="companylogo" class="dropify2" data-height="200" data-default-file="{{ $companylogo }}" required />
                                    <small class="form-text text-muted">
                                        Recommended dimensions: 1080x1080 or 2048x2048 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-control-label">Decal Logo: <span class="tx-danger">*</span></label>
                                    <input type="file" name="decal_logo" value="" id="decallogo" class="dropify2" data-height="200" data-default-file="{{ $decallogo }}" required />
                                    <small class="form-text text-muted">
                                        Recommended dimensions: 1000x500 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-control-label">Detailing Decal: <span class="tx-danger">*</span></label>
                                    <input type="file" name="detailing_decal" value="" id="detailingdecal" class="dropify2" data-height="200" data-default-file="{{ $detailing_decal }}" required />
                                    <small class="form-text text-muted">
                                        Recommended dimensions: 1000x500 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Videos: <span class="tx-danger">*</span></label>
                                    <input type="file" name="video" value=""  id="browseFile" class="dropify2" data-height="200" data-default-file="{{ $video }}" accept="video/*" />
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
                        </section>
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