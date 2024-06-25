@extends('dashboard.layouts.master')

@section('title', 'Detailing')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Tint Brand Table</h3>
                <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.detailing.create') }}'">Add detailing package</button>
            </div>
            @if(auth()->user()->type === "super_admin")
            <div class="card-body">
                <form action="{{ route('dashboard.detailing.index') }}" method="GET">
                    @csrf
                    <div class="col-md-3 col-lg-6 mb-2 d-flex justify-content-between">
                        <label class="form-control-label">Filter by:</label>
                    </div>

                    <div class="col-md-3 col-lg-6 mb-2 d-flex justify-content-between">
                        <select name="user_id" id="user_id" class="form-control paintProtectionFil select2">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="col-md-2 col-lg-1 mb-2">
                            <button type="submit" class="btn btn-primary ms-2px">Filter</button>
                        </div>
                    </div>

                  
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection