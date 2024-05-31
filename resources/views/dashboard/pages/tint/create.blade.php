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
                <form action="{{ route('dashboard.tint.store') }}" method="post">
                    @csrf
                    <div id="wizard2">
                        <h3>Tint Brand</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Brand Image: <span class="tx-danger">*</span></label>
                                    <input type="file" name="tint_image" class="dropify" data-height="200" />
                                </div>
                                <div class="col-md-5 col-lg-4 mb-2">
                                    <label class="form-control-label">Brand Name: <span class="tx-danger">*</span></label> <input class="form-control" id="firstname" name="tint" placeholder="Tint Brand" required="" type="text">
                                </div>
                                <div class="col-12 mg-t-20 mg-md-t-0 mb-2">
                                    <label class="form-control-label">Brand Description: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" id="lastname" name="tint_description" placeholder="Textarea" rows="3" required></textarea>
                                </div>
                            </div>
                        </section>
                        <h3>Tint Details</h3>
                        <section>
                            <div class="row row-sm">
                                <div class="col-12 mb-2">
                                    <label class="form-control-label"><h5>Luxury, Sedan:</h5></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Prices:</label>
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front w.s" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front two" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="back half" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="full car" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 mt-3">
                                    <label class="form-control-label"><h5>Luxury, Coupe:</h5></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Prices:</label>
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front w.s" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front two" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="back half" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="full car" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 mt-3">
                                    <label class="form-control-label"><h5>Electric, SUV:</h5></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Prices:</label>
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front w.s" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front two" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="back half" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="full car" required="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 mt-3">
                                    <label class="form-control-label"><h5>Electric, Sedan:</h5></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-control-label">Prices:</label>
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front w.s" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="front two" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="back half" required="" type="text">
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <input class="form-control" placeholder="full car" required="" type="text">
                                        </div>
                                    </div>
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