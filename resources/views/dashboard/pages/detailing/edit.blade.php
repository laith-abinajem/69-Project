@extends('dashboard.layouts.master')

@section('title', 'Edit Detaing Package')

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
                <h3 class="tile-title">{{ __('Edit Detaing Package') }}</h3>
                <form action="{{ route('dashboard.detailing.update', $detailingBrand->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="wizardedit">
                        <h3>Detaing Package</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Detailing Image: <span class="tx-danger">*</span></label>
                                    <input type="file" name="detailing_image" value="{{ old('detailing_image') }}" id="brandimage" class="dropify2" data-default-file="{{ $photos }}" data-height="200" required />
                                    <small class="form-text text-muted">
                                     Recommended dimensions: 1000x500 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Detailing Brand: <span class="tx-danger">*</span></label> <input class="form-control" id="brandname" name="detailing_brand" value="{{ $detailingBrand->detailing_brand }}" placeholder="Detailing Brand" required="" type="text">
                                </div>
                                @if(auth()->user()->type === "super_admin")
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label ">Users: <span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control paintProtectionFil ">
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" {{ $user->id == $detailingBrand->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>detailingBrand
                                </div>
                                @endif
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Detailing type<span class="tx-danger">*</span></label>
                                    <select name="detailing_type" id="detailing_type" class="form-control paintProtectionFil " >
                                        <option value="exterior" {{ $detailingBrand->detailing_type == 'exterior' ? 'selected' : '' }}>Exterior</option>
                                        <option value="interior" {{ $detailingBrand->detailing_type == 'interior' ? 'selected' : '' }}>Interior</option>
                                        <option value="inout" {{ $detailingBrand->detailing_type == 'inout' ? 'selected' : '' }}>IN & OUT</option>
                                        <option value="ceramic_coating" {{ $detailingBrand->detailing_type == 'ceramic_coating' ? 'selected' : '' }}>Ceramic coating</option>
                                        <option value="paint_correction" {{ $detailingBrand->detailing_type == 'paint_correction' ? 'selected' : '' }}>Paint correction</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">guage level<span class="tx-danger">*</span></label>
                                    <select name="guage_level" id="guage_level" class="form-control paintProtectionFil " >
                                        <option value="1" {{ $detailingBrand->guage_level == 1 ? 'selected' : '' }}>1 minimum heat rejection</option>
                                        <option value="2" {{ $detailingBrand->guage_level == 2 ? 'selected' : '' }}>2 good heat rejection </option>
                                        <option value="3" {{ $detailingBrand->guage_level == 3 ? 'selected' : '' }}>3 very good heat rejection </option>
                                        <option value="4" {{ $detailingBrand->guage_level == 4 ? 'selected' : '' }}>4 excellent heat rejection</option>
                                        <option value="5" {{ $detailingBrand->guage_level == 5 ? 'selected' : '' }}>5 maximum heat reject </option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                    <br>
                                    <div class="color-picker-container">
                                        <input type="color" id="colorPicker" name="colorPicker"  value="{{ $detailingBrand->hex }}">
                                        <input type="text" id="hex" name="hex" required="" value="{{ $detailingBrand->hex }}" maxlength="7">
                                    </div>
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="detailing_description" placeholder="Textarea" rows="3" required>{{ $detailingBrand->detailing_description }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Package Details</h3>
                        <section>
                            <div class="row row-sm">
                                @php
                                    $class = ['Regular', 'Luxury', 'Electric (Tesla)', 'Electric'];
                                    $subclass = ['Coupe', 'Sedan', 'SUV', '7 seater SUV' ,'TRUCK'];
                                    $counter = 1;
                                @endphp
                                <div class="panel-group1" id="accordion11">
                                    @foreach($class as $class_item)
                                
                                        <div class="panel panel-default  mb-4">
                                            <div class="panel-heading1 bg-primary ">
                                                <h4 class="panel-title1">
                                                    <a class="accordion-toggle collapsed" data-bs-toggle="collapse"
                                                        data-bs-parent="#accordion11" href="#collapse{{ $counter }}"
                                                        aria-expanded="false"><i class="fe fe-arrow-right me-2"></i>{{ $class_item }}</a>
                                                </h4>
                                            </div>
                                            <div id="collapse{{ $counter }}" class="panel-collapse collapse" role="tabpanel"
                                                aria-expanded="false">
                                                @foreach($subclass as $subclass_item)
                                                <div class="col-12 mb-2 mt-3">
                                                    <label class="form-control-label"><h5>{{ $class_item }}, {{ $subclass_item }}:</h5></label>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label class="form-control-label">Price:</label>
                                                    <div class="row prices_container">
                                                        <div class="col-12 col-md-3 mb-2">
                                                            @php
                                                                $detail = $detailingBrand->detailingDetails->where('class_car', $class_item)->where('sub_class_car', $subclass_item)->first();
                                                                
                                                            @endphp
                                                            <input class="form-control front-w-s" name="price[{{ $class_item }}][{{ $subclass_item }}][price]" value="{{ $detail->price }}" placeholder="Price" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <button type="button" class="btn btn-secondary copy">Copy</button>
                                                            <button type="button" class="btn btn-primary paste " style="display: none;">Paste</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php 
                                                    $counter++;
                                                @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection