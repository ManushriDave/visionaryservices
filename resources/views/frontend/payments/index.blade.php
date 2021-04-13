@extends('layouts.frontend')

@section('title', 'Payments')

@section('head')
    @include('frontend.head.datatable')
@endsection

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"><small>All</small> Payments</h3>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th class="d-none d-sm-table-cell">Amount</th>
                        <th class="d-none d-sm-table-cell">Date</th>
                        <th>Appointment</th>
                    </tr>
                </thead>
                <tbody>
                @if($payments)
                    @foreach ($payments as $payment)
                        <tr>
                            <td class="text-center"># {{ $payment->payment_id }}</td>
                            <td class="font-w600">{{ \App\Enums\Currency::default.' '.$payment->total }}</td>
                            <td class="d-none d-sm-table-cell">{{ \Carbon\Carbon::parse($payment->created_at)->toDateTimeLocalString() }}</td>
                            <td class="text-center">
                                <a href="{{ route('frontend.bookings.show', $payment->appointment->id) }}" class="btn btn-sm btn-primary">
                                    View Appointment
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @include('frontend.scripts.datatable')
@endsection
