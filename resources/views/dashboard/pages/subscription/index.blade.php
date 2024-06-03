@extends('dashboard.layouts.master')

@section('title', 'Subscription')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Subscription Table</h3>
                <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.subscription.create') }}'">Add Subscription</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">Subscription Type</th>
                                <th class="border-bottom-0">Expiry date</th>
                                <th class="border-bottom-0">User</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->package_type}} Month</td>
                                <td>{{$item->end_date}}</td>
                                <td>{{$item->user->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection