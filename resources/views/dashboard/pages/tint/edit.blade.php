@extends('dashboard.layouts.master')

@section('title', 'Edit Tint')

@section('content')

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
                <form action="{{ route('dashboard.tint.update', $tintBrand->id) }}" method="post" id="tintform" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="wizard1">
                        <h3>Tint Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image:</label>
                                    <input type="file" name="tint_image" id="brandimage" class="dropify" data-default-file="{{ $photos }}" data-height="200" />
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="brandname" name="tint_brand" value="{{ $tintBrand->tint_brand }}" placeholder="Tint Brand" required type="text">
                                </div>
                                @if(auth()->user()->type === "super_admin")
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Users: <span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control paintProtectionFil " >
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" {{ $user->id == $tintBrand->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                               
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">guage level<span class="tx-danger">*</span></label>
                                    <select name="guage_level" id="guage_level" class="form-control paintProtectionFil">
                                        <option value="1" {{ $tintBrand->guage_level == 1 ? 'selected' : '' }}>1 minimum heat rejection</option>
                                        <option value="2" {{ $tintBrand->guage_level == 2 ? 'selected' : '' }}>2 good heat rejection</option>
                                        <option value="3" {{ $tintBrand->guage_level == 3 ? 'selected' : '' }}>3 very good heat rejection</option>
                                        <option value="4" {{ $tintBrand->guage_level == 4 ? 'selected' : '' }}>4 excellent heat rejection</option>
                                        <option value="5" {{ $tintBrand->guage_level == 5 ? 'selected' : '' }}>5 maximum heat reject</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                    <br>
                                    <div class="color-picker-container">
                                        <input type="color" id="colorPicker" name="colorPicker"  value="{{$tintBrand->hex}}">
                                        <input type="text" id="hex" name="hex"  value="{{$tintBrand->hex}}" maxlength="7">
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Tint brand level: <span class="tx-danger">*</span></label> 
                                    <select name="tint_brand_level" id="tint_brand_level" class="form-control paintProtectionFil">
                                        <option value="5" {{ $tintBrand->tint_brand_level == 5 ? 'selected' : '' }}>5</option>
                                        <option value="20" {{ $tintBrand->tint_brand_level == 20 ? 'selected' : '' }}>20 </option>
                                        <option value="35" {{ $tintBrand->tint_brand_level == 35 ? 'selected' : '' }}>35 </option>
                                        <option value="50" {{ $tintBrand->tint_brand_level == 50 ? 'selected' : '' }}>50 </option>
                                        <option value="70" {{ $tintBrand->tint_brand_level == 70 ? 'selected' : '' }}>70</option>
                                    </select>
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="tint_description" placeholder="Textarea" rows="3" required>{{ $tintBrand->tint_description }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Tint Details</h3>
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
                                                        $details = $tintBrand->tintDetails->where('class_car', $class_item)->where('sub_class_car', $subclass_item);
                                                    @endphp
                                                    <div class="col-12 mb-2 mt-3">
                                                        <label class="form-control-label"><h5>{{ $class_item }}, {{ $subclass_item }}:</h5></label>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <label class="form-control-label">Prices:</label>
                                                        <div class="row prices_container">
                                                            @foreach(['1_price' => 'front w.s', '2_price' => 'front two', '3_price' => 'back half', '4_price' => 'moonroof', '5_price' => 'full car', '6_price' => 'panoramic_moonroof', '7_price' => 'stripe tint'] as $key => $placeholder)
                                                                @php $html_class = str_replace(" ","-",$placeholder); $html_class = str_replace(".","-",$html_class) @endphp
                                                                <div class="col-12 col-md-3 mb-2">
                                                                    <input class="form-control {{ $html_class }}" name="price[{{ $class_item }}][{{ $subclass_item }}][{{ $key }}]" value="{{ $details->firstWhere('window', explode('_', $key)[0])->price ?? '' }}" placeholder="{{ $placeholder }}" required type="text">
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