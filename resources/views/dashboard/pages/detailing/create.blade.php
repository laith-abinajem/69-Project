@extends('dashboard.layouts.master')

@section('title', 'Create Detaing Package')

@section('content')

<style>
    .color-picker-container {
        display: inline-flex;
        align-items: center;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
    }

    .color-picker-container input[type="text"] {
        width: 80px;
        margin-left: 10px;
        border: none;
        border-left: 1px solid #ccc;
        padding-left: 5px;
        height: 30px;
    }

    .color-picker-container input[type="color"] {
        border: none;
        height: 30px;
        width: 40px;
        padding: 0;
    }
</style>

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
                <h3 class="tile-title">{{ __('Create Detaing Package') }}</h3>
                <form action="{{ route('dashboard.detailing.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">Detailing Brand: <span class="tx-danger">*</span></label>
                                <input value="{{ old('detailing_brand') }}" class="form-control" name="detailing_brand" placeholder="Detailing Brand" required="" type="text">
                            </div>
                        </div>
                        @if(auth()->user()->type === "super_admin")
                        <div class="form-group col-6">
                            <label class="form-control-label ">Users: <span class="tx-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control paintProtectionFil ">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group col-6">
                            <label class="form-control-label">Detailing type<span class="tx-danger">*</span></label>
                            <select name="detailing_type" id="detailing_type" required class="form-control paintProtectionFil select2" >
                                <option selected @if($exterior_count >= 4) disabled @endif value="exterior" >Exterior</option>
                                <option @if($interior_count >= 4) disabled @endif value="interior">Interior</option>
                                <option @if($inout_count >= 4) disabled @endif value="inout">IN & Out</option>
                            </select>
                        </div>
                        <div class="col-md-5 col-lg-6 mb-2">
                            <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                            <br>
                            <div class="color-picker-container">
                                <input type="color" id="colorPicker" name="colorPicker"  value="#ff0000">
                                <input type="text" id="hex" name="hex" required="" value="#ff0000" maxlength="7">
                            </div>
                        </div>
                        <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                            <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" placeholder="Textarea" rows="3" required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" class="button btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.detailing.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection