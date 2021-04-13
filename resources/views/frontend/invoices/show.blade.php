@extends('layouts.frontend')

@section('title', 'Invoice #'.$invoice->id)

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ '#INVOICE_'.$invoice->id }}</h3>
            <div class="block-options">
                <!-- Print Page functionality is initialized in Helpers.print() -->
                <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                    <i class="si si-printer"></i> Print Invoice
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <!-- Invoice Info -->
            <div class="row my-20">
                <!-- Company Info -->
                <div class="col-6">
                    <p class="h3">Visionary Services</p>
                    <address>
                        Street Address<br>
                        State, City<br>
                        Region, Postal Code<br>
                        admin@niftyassistance.com
                    </address>
                </div>
                <!-- END Company Info -->

                <!-- Client Info -->
                <div class="col-6 text-right">
                    <p class="h3">{{ $invoice->user->name }}</p>
                    <address>
                        Street Address<br>
                        State, City<br>
                        Region, Postal Code<br>
                        {{ $invoice->user->email }}
                    </address>
                </div>
                <!-- END Client Info -->
            </div>
            <!-- END Invoice Info -->

            <!-- Table -->
            <div class="table-responsive push">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Service</th>
                        <th>Status</th>
                        <th class="text-center">Estimated Time</th>
                        <th class="text-right">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <p class="font-w600 mb-5">{{ $invoice->getTasks() }}</p>
                            <div class="text-muted"></div>
                        </td>
                        <td class="text-center">
                            <h5>
                                <span class="badge badge-primary">
                                    {{ \App\Enums\AppointmentStatus::getKey($invoice->status) }}
                                </span>
                            </h5>
                        </td>
                        <td class="text-center font-weight-bold">
                            {{ $invoice->approx_duration }} hours
                        </td>
                        <td class="text-center">{{ \App\Enums\Currency::default }} {{ $invoice->total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- END Table -->

            <!-- Footer -->
            <p class="text-muted text-center">Thank you very much for doing business with us. We look forward to working with you again!</p>
            <!-- END Footer -->
        </div>
    </div>
@endsection
