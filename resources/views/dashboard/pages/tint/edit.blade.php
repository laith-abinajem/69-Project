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
                <form action="{{ route('dashboard.tint.edit', $data->id) }}" method="PUT" id="tintform">
                    @csrf
                    <div id="wizard2">
                        <h3>Tint Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image: <span class="tx-danger">*</span></label>
                                    <input type="file" name="tint_image" value="{{ old('tint_image') }}" id="brandimage" class="dropify" data-height="200" required />
                                </div>
                                <div class="col-md-5 col-lg-4 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label> <input class="form-control" id="brandname" name="tint_brand" value="{{ $data->tint_brand }}" placeholder="Tint Brand" required="" type="text">
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="branddescription" name="tint_description" placeholder="Textarea" rows="3" required>{{ $data->tint_description }}</textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Tint Details</h3>
                        <section>
                            <div class="row row-sm">
                                @php
                                    $class = ['Luxury', 'Regular', 'Electric', 'Others'];
                                    $subclass = ['SUV', 'Sedan', 'Coupe', 'Truck'];
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
                                                            <input class="form-control front-ws" name="price[{{ $class_item }}][{{ $subclass_item }}][frontws_price]" placeholder="front w.s" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control front-two" name="price[{{ $class_item }}][{{ $subclass_item }}][fronttwo_price]" placeholder="front two" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control back-half" name="price[{{ $class_item }}][{{ $subclass_item }}][backhalf_price]" placeholder="back half" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control moonroof" name="price[{{ $class_item }}][{{ $subclass_item }}][moonroof_price]" placeholder="moonroof" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <input class="form-control full-car" name="price[{{ $class_item }}][{{ $subclass_item }}][fullcar_price]" placeholder="full car" required="" type="text">
                                                        </div>
                                                        <div class="col-12 col-md-2">
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

@endsection