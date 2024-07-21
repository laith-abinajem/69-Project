@extends('dashboard.layouts.master')

@section('title', 'Edit Light tint')

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
                <form action="{{ route('dashboard.light.update', $lightTint->id) }}" method="post" id="tintform" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="wizard1">
                        <h3>Light Tint Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image:</label>
                                    <input type="file" name="light_image" id="brandimage" class="dropify2 largeDropify" data-default-file="{{ $photos }}" data-height="200" />
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="brandname" name="light_brand" value="{{ $lightTint->light_brand }}" placeholder="Light Tint Brand" required type="text">
                                </div>
                                @if(auth()->user()->type === "super_admin")
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Users: <span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control paintProtectionFil " >
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" {{ $user->id == $lightTint->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                               
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Warranty<span class="tx-danger">*</span></label>
                                    <select name="warranty" id="warranty" class="form-control paintProtectionFil">
                                        <option value="1" {{ $lightTint->warranty == 1 ? 'selected' : '' }}>1 year</option>
                                        <option value="2" {{ $lightTint->warranty == 2 ? 'selected' : '' }}>2 year</option>
                                        <option value="3" {{ $lightTint->warranty == 3 ? 'selected' : '' }}>3 year</option>
                                        <option value="4" {{ $lightTint->warranty == 4 ? 'selected' : '' }}>4 year</option>
                                        <option value="5" {{ $lightTint->warranty == 5 ? 'selected' : '' }}>5 year</option>
                                    </select>
                                </div>
                                <div class="col-md-5 col-lg-6 mb-2">
                                    <label class="form-control-label">Choose a Color <span class="tx-danger">*</span></label>
                                    <br>
                                    <div class="color-picker-container">
                                        <input type="color" id="colorPicker" name="colorPicker"  value="{{$lightTint->hex}}">
                                        <input type="text" id="hex" name="hex" required="" value="{{$lightTint->hex}}" maxlength="7">
                                    </div>
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="light_description" placeholder="Textarea" rows="3" required>{{ $lightTint->light_description }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Light Tint Details</h3>
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
                                                        $details = $lightTint->lightDetails->where('class_car', $class_item)->where('sub_class_car', $subclass_item);
                                                        $detail = $tintBrand->lightDetails
                                                        ->where('class_car', $class_item)
                                                        ->where('sub_class_car', $subclass_item)
                                                        ->first();
                                                    @endphp
                                                    <div class="col-12 mb-2 mt-3">
                                                        <label class="form-control-label"><h5>{{ $class_item }}, {{ $subclass_item }}:</h5></label>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <label class="form-control-label">Prices:</label>
                                                        <div class="row prices_container">
                                                            @foreach(['head_price' => 'Head Price', 'fog_price' => 'Fog Price', 'tail_price' => 'tail Price'] as $key => $placeholder)
                                                                @php
                                                                    $html_class = str_replace(" ", "-", $placeholder);
                                                                    $html_class = str_replace(".", "-", $html_class);
                                                                    $price = $details->firstWhere('light_type', explode('_', $key)[0])->price ?? '';
                                                                @endphp
                                                                <div class="col-12 col-md-3">
                                                                    <input class="form-control {{ $html_class }}" name="price[{{ $class_item }}][{{ $subclass_item }}][{{ $key }}]" value="{{ $price }}" placeholder="{{ $placeholder }}" required type="text">
                                                                </div>
                                                            @endforeach
                                                            <div class="col-12 col-md-3">
                                                                <button type="button" class="btn btn-secondary copy">Copy</button>
                                                                <button type="button" class="btn btn-primary paste" style="display: none;">Paste</button>
                                                            </div>
                                                            <div class="col-12">
                                                                <label lass="form-control-label">Hide on simulator:</label>
                                                                <div class=" {{ $detail && $detail->status === 'true' ? 'main-toggle on' : 'main-toggle' }}">
                                                                    <span></span>
                                                                    <input type="hidden" class="toggle-value" name="hide[{{ $class_item }}][{{ $subclass_item }}]" value="{{ $detail ? $detail->status : 'false' }}" />
                                                                </div>
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