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
                            <div class="form-group col-6">
                                <label class="form-label">User type: <span class="tx-danger">*</span></label>
                                <select name="type" id="type" required class="form-control paintProtectionFil select2 select2-no-search" >
                                    <option value="super_admin" {{ $data->type == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="subscriber" {{ $data->type == 'subscriber' ? 'selected' : '' }}>Subscriber</option>
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
                                <div class="form-group position-relative">
                                    <label class="form-label">Password:</label>
                                    <input value="{{ old('password') }}" id="password" class="form-control" name="password" placeholder="Enter password" type="password">
                                    <i class="bi bi-eye-slash position-absolute" id="togglePassword"  onclick="showPassword()"></i>
                                </div>
                            </div>
                           
                            @if(auth()->user()->type === "super_admin" || (auth()->user()->type === "subscriber" && $data->type !== 'employee' ) )
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Company Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->company_name }}" class="form-control" name="company_name" placeholder="Company name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Currency <span class="tx-danger">*</span></label>
                                    <select name="currency" id="currency" required class="form-control paintProtectionFil select2">
                                        <option value="USD" <?= $data->currency == 'USD' ? 'selected' : '' ?>>US Dollar (USD)</option>
                                        <option value="EUR" <?= $data->currency == 'EUR' ? 'selected' : '' ?>>Euro (EUR)</option>
                                        <option value="JPY" <?= $data->currency == 'JPY' ? 'selected' : '' ?>>Japanese Yen (JPY)</option>
                                        <option value="GBP" <?= $data->currency == 'GBP' ? 'selected' : '' ?>>British Pound (GBP)</option>
                                        <option value="AUD" <?= $data->currency == 'AUD' ? 'selected' : '' ?>>Australian Dollar (AUD)</option>
                                        <option value="CAD" <?= $data->currency == 'CAD' ? 'selected' : '' ?>>Canadian Dollar (CAD)</option>
                                        <option value="CHF" <?= $data->currency == 'CHF' ? 'selected' : '' ?>>Swiss Franc (CHF)</option>
                                        <option value="CNY" <?= $data->currency == 'CNY' ? 'selected' : '' ?>>Chinese Yuan (CNY)</option>
                                        <option value="SEK" <?= $data->currency == 'SEK' ? 'selected' : '' ?>>Swedish Krona (SEK)</option>
                                        <option value="NZD" <?= $data->currency == 'NZD' ? 'selected' : '' ?>>New Zealand Dollar (NZD)</option>
                                        <option value="MXN" <?= $data->currency == 'MXN' ? 'selected' : '' ?>>Mexican Peso (MXN)</option>
                                        <option value="SGD" <?= $data->currency == 'SGD' ? 'selected' : '' ?>>Singapore Dollar (SGD)</option>
                                        <option value="HKD" <?= $data->currency == 'HKD' ? 'selected' : '' ?>>Hong Kong Dollar (HKD)</option>
                                        <option value="NOK" <?= $data->currency == 'NOK' ? 'selected' : '' ?>>Norwegian Krone (NOK)</option>
                                        <option value="KRW" <?= $data->currency == 'KRW' ? 'selected' : '' ?>>South Korean Won (KRW)</option>
                                        <option value="TRY" <?= $data->currency == 'TRY' ? 'selected' : '' ?>>Turkish Lira (TRY)</option>
                                        <option value="INR" <?= $data->currency == 'INR' ? 'selected' : '' ?>>Indian Rupee (INR)</option>
                                        <option value="RUB" <?= $data->currency == 'RUB' ? 'selected' : '' ?>>Russian Ruble (RUB)</option>
                                        <option value="BRL" <?= $data->currency == 'BRL' ? 'selected' : '' ?>>Brazilian Real (BRL)</option>
                                        <option value="ZAR" <?= $data->currency == 'ZAR' ? 'selected' : '' ?>>South African Rand (ZAR)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Language <span class="tx-danger">*</span></label>
                                    <select name="language" id="language" required class="form-control paintProtectionFil select2">
                                        <option value="en" <?= $data->language == 'en' ? 'selected' : '' ?>>English</option>
                                        <option value="zh" <?= $data->language == 'zh' ? 'selected' : '' ?>>Chinese</option>
                                        <option value="es" <?= $data->language == 'es' ? 'selected' : '' ?>>Spanish</option>
                                        <option value="hi" <?= $data->language == 'hi' ? 'selected' : '' ?>>Hindi</option>
                                        <option value="bn" <?= $data->language == 'bn' ? 'selected' : '' ?>>Bengali</option>
                                        <option value="pt" <?= $data->language == 'pt' ? 'selected' : '' ?>>Portuguese</option>
                                        <option value="ru" <?= $data->language == 'ru' ? 'selected' : '' ?>>Russian</option>
                                        <option value="ja" <?= $data->language == 'ja' ? 'selected' : '' ?>>Japanese</option>
                                        <option value="de" <?= $data->language == 'de' ? 'selected' : '' ?>>German</option>
                                        <option value="fr" <?= $data->language == 'fr' ? 'selected' : '' ?>>French</option>
                                        <option value="ko" <?= $data->language == 'ko' ? 'selected' : '' ?>>Korean</option>
                                        <option value="it" <?= $data->language == 'it' ? 'selected' : '' ?>>Italian</option>
                                        <option value="ta" <?= $data->language == 'ta' ? 'selected' : '' ?>>Tamil</option>
                                        <option value="te" <?= $data->language == 'te' ? 'selected' : '' ?>>Telugu</option>
                                        <option value="vi" <?= $data->language == 'vi' ? 'selected' : '' ?>>Vietnamese</option>
                                        <option value="ur" <?= $data->language == 'ur' ? 'selected' : '' ?>>Urdu</option>
                                        <option value="tr" <?= $data->language == 'tr' ? 'selected' : '' ?>>Turkish</option>
                                        <option value="fa" <?= $data->language == 'fa' ? 'selected' : '' ?>>Persian</option>
                                        <option value="pl" <?= $data->language == 'pl' ? 'selected' : '' ?>>Polish</option>
                                        <option value="nl" <?= $data->language == 'nl' ? 'selected' : '' ?>>Dutch</option>
                                        <option value="el" <?= $data->language == 'el' ? 'selected' : '' ?>>Greek</option>
                                        <option value="he" <?= $data->language == 'he' ? 'selected' : '' ?>>Hebrew</option>
                                        <option value="th" <?= $data->language == 'th' ? 'selected' : '' ?>>Thai</option>
                                        <option value="sv" <?= $data->language == 'sv' ? 'selected' : '' ?>>Swedish</option>
                                        <option value="hu" <?= $data->language == 'hu' ? 'selected' : '' ?>>Hungarian</option>
                                        <option value="fi" <?= $data->language == 'fi' ? 'selected' : '' ?>>Finnish</option>
                                        <option value="da" <?= $data->language == 'da' ? 'selected' : '' ?>>Danish</option>
                                        <option value="no" <?= $data->language == 'no' ? 'selected' : '' ?>>Norwegian</option>
                                        <option value="ro" <?= $data->language == 'ro' ? 'selected' : '' ?>>Romanian</option>
                                        <option value="cs" <?= $data->language == 'cs' ? 'selected' : '' ?>>Czech</option>
                                        <option value="sk" <?= $data->language == 'sk' ? 'selected' : '' ?>>Slovak</option>
                                        <option value="bg" <?= $data->language == 'bg' ? 'selected' : '' ?>>Bulgarian</option>
                                        <option value="hr" <?= $data->language == 'hr' ? 'selected' : '' ?>>Croatian</option>
                                        <option value="sr" <?= $data->language == 'sr' ? 'selected' : '' ?>>Serbian</option>
                                        <option value="uk" <?= $data->language == 'uk' ? 'selected' : '' ?>>Ukrainian</option>
                                        <option value="ca" <?= $data->language == 'ca' ? 'selected' : '' ?>>Catalan</option>
                                        <option value="ms" <?= $data->language == 'ms' ? 'selected' : '' ?>>Malay</option>
                                        <option value="id" <?= $data->language == 'id' ? 'selected' : '' ?>>Indonesian</option>
                                        <option value="tl" <?= $data->language == 'tl' ? 'selected' : '' ?>>Tagalog</option>
                                        <option value="et" <?= $data->language == 'et' ? 'selected' : '' ?>>Estonian</option>
                                        <option value="lv" <?= $data->language == 'lv' ? 'selected' : '' ?>>Latvian</option>
                                        <option value="lt" <?= $data->language == 'lt' ? 'selected' : '' ?>>Lithuanian</option>
                                        <option value="sl" <?= $data->language == 'sl' ? 'selected' : '' ?>>Slovenian</option>
                                        <option value="mt" <?= $data->language == 'mt' ? 'selected' : '' ?>>Maltese</option>
                                        <option value="is" <?= $data->language == 'is' ? 'selected' : '' ?>>Icelandic</option>
                                        <option value="ga" <?= $data->language == 'ga' ? 'selected' : '' ?>>Irish</option>
                                        <option value="sq" <?= $data->language == 'sq' ? 'selected' : '' ?>>Albanian</option>
                                    </select>
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
                                    <input type="color" id="colorPicker"  value="{{$data->hex}}"name="colorPicker" >
                                    <input type="text" id="hex" name="hex" value="{{$data->hex}} "required="" maxlength="7">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Company Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="company_logo" value="{{ old('company_logo') }}" id="company_logo" class="dropify largeDropify2" data-height="200" data-default-file="{{ $companyLogo }}" />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1080x1080 or 2048x2048 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Decal Logo: <span class="tx-danger">*</span></label>
                                <input type="file" name="decal_logo" value="{{ old('decal_logo') }}" id="decal_logo" class="dropify largeDropify" data-height="200" data-default-file="{{ $decalLogo }}" />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1000x500 or 2048x2048 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-control-label">Detailing Decal: <span class="tx-danger">*</span></label>
                                <input type="file" name="detailing_decal" value="{{ old('detailing_decal') }}" id="detailingdecal" class="dropify largeDropify" data-height="200" data-default-file="{{ $detailing_decal }}"  />
                                <small class="form-text text-muted">
                                    Recommended dimensions: 1000x500 pixels, transparent background
                                </small>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="form-control-label">Videos: <span class="tx-danger">*</span></label>
                                <input type="file" name="video" value="{{ old('video') }}" id="browseFile" class="dropify" data-height="200" data-default-file="{{ $video }}" accept="video/*" />
                                <small class="form-text text-muted">Please upload a high-resolution video  of at least 1280x720 , not a mobile version.</small>
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
                            @endif
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
        getVideoResolution(file.file, function(width, height) {
            if ((width >= 1280 && height >= 720)) {
                showProgress();
                resumable.upload(); // to actually start uploading.
            } else {
                showProgress();
                resumable.upload(); // to actually start uploading.
                alert('Please upload a video with a resolution of at least 1280x720.');
            }
        });
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
    function getVideoResolution(file, callback) {
        let video = document.createElement('video');
        video.preload = 'metadata';

        video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src);
            callback(video.videoWidth, video.videoHeight);
        };

        video.src = URL.createObjectURL(file);
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