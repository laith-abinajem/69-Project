@extends('dashboard.layouts.master')

@section('title', 'Tints')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Tint Brand Table</h3>
                <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.tint.create') }}'">Add Tint</button>
            </div>
            @if(auth()->user()->type === "super_admin")
                <form action="{{ route('dashboard.tint.index') }}" method="GET">
                    @csrf
                    <div class="col-md-3 col-lg-4 mb-2">
                        <label class="form-control-label">Filter by:</label>
                        <select name="user_id" id="user_id" class="form-control paintProtectionFil select2">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-1 mb-2">
                        <button type="submit" class="btn btn-primary ms-2px">Filter</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection