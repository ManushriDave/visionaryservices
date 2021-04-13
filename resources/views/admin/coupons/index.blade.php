@extends('layouts.admin')

@section('title', 'Nifty Coupons')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Coupons</h4>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a class="btn btn-primary" href="{{ route('admin.coupons.create') }}">
                        Add New Coupon
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example5" class="display">
                        <thead>
                        <th>Coupon</th>
                        <th>Discount (in %)</th>
                        <th>Min. Value</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($coupons)
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->coupon }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ $coupon->minimum_value }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form method="post" action="{{ route('admin.coupons.destroy', $coupon->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Coupon?')"
                                                        class="btn btn-danger shadow btn-xs sharp">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('admin.scripts.datatable')
@endsection
