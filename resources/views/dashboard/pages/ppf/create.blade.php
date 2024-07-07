@extends('dashboard.layouts.master')

@section('title', 'Create PPF ')

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
                <form action="{{ route('dashboard.ppf.store') }}" method="post" id="tintform" enctype="multipart/form-data">
                    @csrf
                    <div id="wizardnew">
                        <h3>Ppf Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image: <span class="tx-danger">*</span></label>
                                    <input type="file" name="ppf_image" value="{{ old('ppf_image') }}" id="brandimage" class="dropify2" data-height="200" required />
                                    <small class="form-text text-muted">
                                     Recommended dimensions: 1000x500 pixels, transparent background
                                    </small>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="brandname" name="ppf_brand" value="{{ old('ppf_brand') }}" placeholder="ppf Brand" required="" type="text">
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
                                    <label class="form-control-label">Warranty<span class="tx-danger">*</span></label>
                                    <select name="warranty" id="warranty" class="form-control paintProtectionFil " >
                                        <option value="1">1 year</option>
                                        <option value="2">2 year </option>
                                        <option value="3">3 year </option>
                                        <option value="4">4 year</option>
                                        <option value="5">5 year </option>
                                        <option value="6">6 year </option>
                                        <option value="7">7 year </option>
                                        <option value="8">8 year </option>
                                        <option value="9">9 year </option>
                                        <option value="10">10 year </option>
                                        <option value="life time">life time </option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Thickness<span class="tx-danger">*</span></label>
                                    <select name="thickness" id="thickness" class="form-control paintProtectionFil " >
                                        <option value="4">4 mm</option>
                                        <option value="5">5 mm</option>
                                        <option value="6">6 mm </option>
                                        <option value="7">7 mm </option>
                                        <option value="8">8 mm </option>
                                        <option value="9">9 mm </option>
                                        <option value="10">10 mm </option>
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
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="ppf_description" placeholder="Textarea" rows="3" required>{{ old('ppf_description') }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Ppf Details</h3>
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
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control front-w-s" name="price[{{ $class_item }}][{{ $subclass_item }}][partialFront_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.partialFront_price') }}" placeholder="Partial front" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control front-two" name="price[{{ $class_item }}][{{ $subclass_item }}][fullFront_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.fullFront_price') }}" placeholder="Full front" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control back-half" name="price[{{ $class_item }}][{{ $subclass_item }}][trackPack_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.trackPack_price') }}" placeholder="Track Pack" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control full-car" name="price[{{ $class_item }}][{{ $subclass_item }}][fullkit_price]" value="{{ old('price.' . $class_item . '.' . $subclass_item . '.fullkit_price') }}" placeholder="Full kit" required="" type="text">
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
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection