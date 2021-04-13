@extends('layouts.admin')

@section('title', 'Create Coupon')

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Coupon</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.coupons.index') }}">
                        Back
                    </a>
                </h4>
            </div>
            <div class="card-body">
                @include('flash::message')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="basic-form">
                    <form method="post" action="{{ route('admin.coupons.store') }}">
                        @include('admin.coupons.fields');
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
