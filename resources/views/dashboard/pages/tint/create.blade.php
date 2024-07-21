@extends('dashboard.layouts.master')

@section('title', 'Create Tint')

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
                <form action="{{ route('dashboard.tint.store') }}" method="post" id="tintform" enctype="multipart/form-data">
                    @csrf
                    <div id="wizard1">
                        <h3>Tint Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image: <span class="tx-danger">*</span></label>
                                    <input type="file" name="tint_image" value="{{ old('tint_image') }}" id="brandimage" class="dropify2 largeDropify" data-height="200" required />
                                    <small class="form-text text-muted">
                                     Recommended dimensions: 1000x500 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label> <input class="form-control" id="brandname" name="tint_brand" value="{{ old('tint_brand') }}" placeholder="Tint Brand" required="" type="text">
                                </div>
                                @if(auth()->user()->type === "super_admin")
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label ">Users: <span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control paintProtectionFil ">
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">guage level<span class="tx-danger">*</span></label>
                                    <select name="guage_level" id="guage_level" class="form-control paintProtectionFil " >
                                        <option value="1">1 minimum heat rejection</option>
                                        <option value="2">2 good heat rejection </option>
                                        <option value="3">3 very good heat rejection </option>
                                        <option value="4">4 excellent heat rejection</option>
                                        <option value="5">5 maximum heat reject </option>
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
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Tint brand level: <span class="tx-danger">*</span></label>
                                     <select name="tint_brand_level" id="brandlevel"  required class="form-control paintProtectionFil " >
                                        <option value="STANDARD">STANDARD </option>
                                        <option value="ADVANCED">ADVANCED </option>
                                        <option value="PREMIUM">PREMIUM </option>
                                        <option value="PREMIUM_PLUS">PREMIUM PLUS</option>
                                        <option value="ELITE">ELITE </option>
                                    </select>
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="tint_description" placeholder="Textarea" rows="3" required>{{ old('tint_description') }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Tint Details</h3>
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
                                                    <label class="form-control-label">Prices:</label>
                                                    <div class="row prices_container">
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control front-w-s" name="price[{{ $class_item }}][{{ $subclass_item }}][1_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.1_price') }}" placeholder="front w.s" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control front-two" name="price[{{ $class_item }}][{{ $subclass_item }}][2_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.2_price') }}" placeholder="front two" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control back-half" name="price[{{ $class_item }}][{{ $subclass_item }}][3_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.3_price') }}" placeholder="back half" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control moonroof" name="price[{{ $class_item }}][{{ $subclass_item }}][4_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.4_price') }}" placeholder="moonroof" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control full-car" name="price[{{ $class_item }}][{{ $subclass_item }}][5_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.5_price') }}" placeholder="full car" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control panoramic-moonroof" name="price[{{ $class_item }}][{{ $subclass_item }}][6_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.6_price') }}" placeholder="panoramic moonroof" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3 mb-2">
                                                            <input class="form-control stripe-tint" name="price[{{ $class_item }}][{{ $subclass_item }}][7_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.7_price') }}" placeholder="stripe tint" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <button type="button" class="btn btn-secondary copy">Copy</button>
                                                            <button type="button" class="btn btn-primary paste " style="display: none;">Paste</button>
                                                        </div>
                                                        <div class="col-12">
                                                            <label lass="form-control-label">Hide on simulator:</label>
                                                            <div class="main-toggle">
                                                                <span></span>
                                                                <input type="hidden" class="toggle-value" name="hide[{{ $class_item }}][{{ $subclass_item }}]" value="false" />
                                                            </div>
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
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection