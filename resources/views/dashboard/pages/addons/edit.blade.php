@extends('dashboard.layouts.master')

@section('title', 'Edit Add-on')

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
                <h3 class="tile-title">{{ __('Edit Add-on') }}</h3>
                <form action="{{ route('dashboard.addons.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row row-sm">
                        <div class="col-12 mb-2">
                            <label class="form-control-label">Add-on image: <span class="tx-danger">*</span></label>
                            <input type="file" name="addon_image" value="{{ old('addon_image') }}" id="addon_image" class="dropify largeDropify" data-height="200" data-default-file="{{ $photos }}" />
                            <small class="form-text text-muted">
                                Recommended dimensions: 1000x500 pixels, transparent background
                            </small>
                        </div>
                        <div class="col-6">
                            <div class="form-group mg-b-0">
                                <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                <input value="{{ $data->name }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Price: <span class="tx-danger">*</span></label>
                                <input value="{{ $data->price }}" class="form-control" name="price" placeholder="Enter Price" required="" type="text">
                            </div>
                        </div>
                        @if(auth()->user()->type === "super_admin")
                        <div class="form-group col-6">
                            <label class="form-control-label">Users: <span class="tx-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control paintProtectionFil ">
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ $user->id == $data->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group col-6">
                            <label class="form-control-label">Service<span class="tx-danger">*</span></label>
                            <select name="service" id="service" required class="form-control paintProtectionFil select2" >
                                <option value="tint" {{ $data->service == 'tint' ? 'selected' : '' }}>Tint</option>
                                <option value="light-tint" {{ $data->service == 'light-tint' ? 'selected' : '' }}>Light tint</option>
                                <option value="ppf" {{ $data->service == 'ppf' ? 'selected' : '' }}>Ppf</option>
                                <option value="detailing" {{ $data->service == 'detailing' ? 'selected' : '' }}>Detailing</option>
                            </select>
                        </div>
                        <div class="col-md-5 col-lg-6 mb-2">
                            <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                            <br>
                            <div class="color-picker-container">
                                <input type="color" id="colorPicker" name="colorPicker"  value="{{ $data->hex }}">
                                <input type="text" id="hex" name="hex" required="" value="{{ $data->hex }}" maxlength="7">
                            </div>
                        </div>
                        <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                            <label class="form-control-label">Add-on Description: <span class="tx-danger">*</span></label>
                            <textarea class="form-control" id="branddescription" name="description" placeholder="Textarea" rows="3" required>{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" class="button btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection