@extends('layouts.frontend')

@section('title', 'Nifty Wallet')

@section('head')
    @include('frontend.head.datatable')
@endsection

@section('content')
    <h2 class="content-heading  p-0"> Payments </h2>

    <div class="row gutters-tiny text-center">
        <!-- Row #1 -->
        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow">
                <div class="block-content block-content-full ">
                    <div class="font-size-sm font-w600 text-muted">Total Transactions</div>
                    <div class="font-size-h2 font-w700">64</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow">
                <div class="block-content block-content-full ">
                    <div class="font-size-sm font-w600 text-muted">Withdrawn</div>
                    <div class="font-size-h2 font-w700">INR 740</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow">
                <div class="block-content block-content-full ">
                    <div class="font-size-sm font-w600 text-muted">Used for Purchases</div>
                    <div class="font-size-h2 font-w700">INR 3,900</div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow">
                <div class="block-content block-content-full ">
                    <div class="font-size-sm font-w600 text-muted">Available for Withdrawal
                        <div class="font-size-h2 font-w700">INR 16,800</div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END Row #1 -->
    </div>

    <div class="row my-4">
        <div class="col-12">
            <!-- Dynamic Table Full -->
            <div class="block Payments">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Transactions</h3>
                    <div class="">
                        <button type="button" class="btn btn-primary min-width-125 ml-auto" data-toggle="click-ripple">
                            Withdrawal
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                    <table class="table table-vcenter js-dataTable-full">
                        <thead>
                        <tr>
                            <th style="width: 15%;">Date</th>
                            <th>Description</th>
                            <th class="text-right" style="width: 15%;">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($transactions)
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>
                                        <h5 class="text-success m-0"><small>INR</small> {{ \Carbon\Carbon::parse($transaction->created_at)->toDateTimeLocalString() }}</h5>
                                    </td>
                                    <td>
                                        {{ $transaction->type }}
                                    </td>
                                    <td class="text-right">
                                        <h5 class="text-success m-0"><small>INR</small> {{ $transaction->amount }}</h5>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Dynamic Table Full -->
        </div>
    </div>
@endsection

@section('scripts')
    @include('frontend.scripts.datatable')
@endsection
