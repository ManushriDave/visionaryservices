@extends('layouts.frontend')

@section('title', 'Invoices')

@section('head')
    @include('frontend.head.datatable')
@endsection

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Invoices <small>All</small></h3>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th class="d-none d-sm-table-cell">Amount</th>
                    <th class="d-none d-sm-table-cell">Due Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="text-center"># {{ $invoice->id }}</td>
                        <td class="font-w600">{{ \App\Enums\Currency::default.' '.$invoice->payment->total }}</td>
                        <td class="d-none d-sm-table-cell">{{ \Carbon\Carbon::parse($invoice->date)->toFormattedDateString() }}</td>
                        <td class="d-none d-sm-table-cell text-center">
                            <span class="badge badge-primary">
                                {{ \App\Enums\AppointmentStatus::getKey($invoice->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('frontend.invoices.show', $invoice->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="View Invoice">
                                <i class="fa fa-paper-plane"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">
                            <h4>
                                <span class="badge badge-info">
                                    No Invoices Found!
                                </span>
                            </h4>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full -->
@endsection

@section('scripts')
    @include('frontend.scripts.datatable')
@endsection
