@extends('dashboard.layouts.master')

@section('title', 'Edit PPF')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

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
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert"> There is something wrong
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('dashboard.ppf.update', $ppfBrand->id) }}" method="post" id="tintform" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="wizardnew">
                        <h3>Ppf Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image:</label>
                                    <input type="file" name="ppf_image" id="brandimage" class="dropify" data-default-file="{{ $photos }}" data-height="200" />
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="brandname" name="ppf_brand" value="{{ $ppfBrand->ppf_brand }}" placeholder="Ppf Brand" required type="text">
                                </div>
                                @if(auth()->user()->type === "super_admin")
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Users: <span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control paintProtectionFil " >
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" {{ $user->id == $ppfBrand->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                               
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Warranty<span class="tx-danger">*</span></label>
                                    <select name="warranty" id="warranty" class="form-control paintProtectionFil">
                                        <option value="1" {{ $ppfBrand->warranty == 1 ? 'selected' : '' }}>1 year</option>
                                        <option value="2" {{ $ppfBrand->warranty == 2 ? 'selected' : '' }}>2 year</option>
                                        <option value="3" {{ $ppfBrand->warranty == 3 ? 'selected' : '' }}>3 year</option>
                                        <option value="4" {{ $ppfBrand->warranty == 4 ? 'selected' : '' }}>4 year</option>
                                        <option value="5" {{ $ppfBrand->warranty == 5 ? 'selected' : '' }}>5 year</option>
                                        <option value="6" {{ $ppfBrand->warranty == 6 ? 'selected' : '' }}>6 year</option>
                                        <option value="7" {{ $ppfBrand->warranty == 7 ? 'selected' : '' }}>7 year</option>
                                        <option value="8" {{ $ppfBrand->warranty == 8 ? 'selected' : '' }}>8 year</option>
                                        <option value="9" {{ $ppfBrand->warranty == 9 ? 'selected' : '' }}>9 year</option>
                                        <option value="10" {{ $ppfBrand->warranty == 10 ? 'selected' : '' }}>10 year</option>
                                        <option value="11" {{ $ppfBrand->warranty == 11 ? 'selected' : '' }}>life time</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Thickness<span class="tx-danger">*</span></label>
                                    <select name="thickness" id="thickness" class="form-control paintProtectionFil">
                                        <option value="4" {{ $ppfBrand->thickness == 4 ? 'selected' : '' }}>4 mm</option>
                                        <option value="5" {{ $ppfBrand->thickness == 5 ? 'selected' : '' }}>5 mm</option>
                                        <option value="6" {{ $ppfBrand->thickness == 6 ? 'selected' : '' }}>6 mm</option>
                                        <option value="7" {{ $ppfBrand->thickness == 7 ? 'selected' : '' }}>7 mm</option>
                                        <option value="8" {{ $ppfBrand->thickness == 8 ? 'selected' : '' }}>8 mm</option>
                                        <option value="9" {{ $ppfBrand->thickness == 9 ? 'selected' : '' }}>9 mm</option>
                                        <option value="10" {{ $ppfBrand->thickness == 10 ? 'selected' : '' }}>10 mm</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                    <br>
                                    <div class="color-picker-container">
                                        <input type="color" id="colorPicker" name="colorPicker"  value="{{$ppfBrand->hex}}">
                                        <input type="text" id="hex" name="hex" required="" value="{{$ppfBrand->hex}}" maxlength="7">
                                    </div>
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="ppf_description" placeholder="Textarea" rows="3" required>{{ $ppfBrand->ppf_description }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Ppf Details</h3>
                        <section>
                            <div class="row row-sm">
                                @php
                                    $class = ['Regular', 'Luxury', 'Electric (Tesla)', 'Electric'];
                                    $subclass = ['Coupe', 'Sedan', 'SUV', '7 seater SUV' ,'TRUCK'];
                                @endphp
                                <div class="panel-group1" id="accordion11">
                                    @foreach($class as $class_index => $class_item)
                                        <div class="panel panel-default mb-4">
                                            <div class="panel-heading1 bg-primary">
                                                <h4 class="panel-title1">
                                                    <a class="accordion-toggle collapsed" data-bs-toggle="collapse"
                                                    data-bs-parent="#accordion11" href="#collapse{{ $class_index }}"
                                                    aria-expanded="false"><i class="fe fe-arrow-right me-2"></i>{{ $class_item }}</a>
                                                </h4>
                                            </div>
                                            <div id="collapse{{ $class_index }}" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                                @foreach($subclass as $subclass_index => $subclass_item)
                                                    @php
                                                        $details = $ppfBrand->ppfDetails->where('class_car', $class_item)->where('sub_class_car', $subclass_item);
                                                    @endphp
                                                    <div class="col-12 mb-2 mt-3">
                                                        <label class="form-control-label"><h5>{{ $class_item }}, {{ $subclass_item }}:</h5></label>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <label class="form-control-label">Prices:</label>
                                                        <div class="row prices_container">
                                                            @foreach(['partialFront_price' => 'Partial front', 'fullFront_price' => 'Full front', 'trackPack_price' => 'Track Pack', 'fullkit_price' => 'Full kit'] as $key => $placeholder)
                                                                @php
                                                                    $html_class = str_replace(" ", "-", $placeholder);
                                                                    $html_class = str_replace(".", "-", $html_class);
                                                                    $price = $details->firstWhere('ppf_type', explode('_', $key)[0])->price ?? '';
                                                                @endphp
                                                                <div class="col-12 col-md-2">
                                                                    <input class="form-control {{ $html_class }}" name="price[{{ $class_item }}][{{ $subclass_item }}][{{ $key }}]" value="{{ $price }}" placeholder="{{ $placeholder }}" required type="text">
                                                                </div>
                                                            @endforeach
                                                            <div class="col-12 col-md-3">
                                                                <button type="button" class="btn btn-secondary copy">Copy</button>
                                                                <button type="button" class="btn btn-primary paste" style="display: none;">Paste</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection