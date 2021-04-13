@extends('layouts.frontend')

@section('title', 'Dashboard')

@section('content')


    <!-- Hero -->
    <div class="block block-rounded">
        <div class="block-content block-content-full bg-pattern"
             style="background-image: url('/assets/frontend/assets/media/various/bg-pattern-inverse.png');">
            <div class="py-20 text-center">
                <h2 class="font-w700 text-black mb-10">
                    Your Dashboard
                </h2>
                <h3 class="h5 text-muted mb-0">
                    You currently have {{ $upcoming_bookings->count() }} upcoming booking and {{ $ongoing_tasks->count() }} ongoing tasks!
                </h3>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Overview -->
    <h2 class="h4 font-w300 mt-50">Overview</h2>
    <div class="row">
        <div class="col-4">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa fa-3x fa-server text-danger"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $all_bookings->count() }} Total
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Bookings Done
                    </p>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa-globe text-primary"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $ongoing_tasks->count() }} Active
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Tasks / Bookings
                    </p>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x  fa-money text-success"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ \App\Enums\Currency::default }} {{ $pending_payment }} Pending
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Payment
                    </p>
                </div>
            </a>
        </div>
    </div>
    <!-- END Overview -->

    <div class="d-flex justify-content-between align-items-center mt-50 mb-20">
        <h2 class="h4 font-w300 mb-0">Active / Upcoming ({{ $upcoming_bookings->count() + $ongoing_tasks->count() }})</h2>
    </div>

    <div class="block block-rounded">
        <div class="block-content">
            <!-- Products Table -->
            <table class="table table-borderless table-striped">
                <thead>
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Status</th>
                    <th>Assigned Date</th>
                    <th>Assigned Time</th>
                    <th>Service</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($ongoing_tasks || $pending_tasks)
                    @foreach ($ongoing_tasks as $task)
                        <tr>
                            <td>
                                <a class="font-w600" href="#">{{ $task->id }}</a>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ \App\Enums\AppointmentStatus::getKey($task->status) }}</span>
                            </td>
                            <td>{{ date('d M, Y', strtotime($task->date)) }}</td>
                            <td>{{ date('h:i A', strtotime($task->time)) }}</td>
                            <td>
                                <a>{{ $task->getTasks() }} </a>
                            </td>
                            <td>
                                <span class="text-black">{{ \App\Enums\Currency::default }} {{ $task->total }}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary btn-rounded" href="{{ route('frontend.bookings.show', $task->id) }}">
                                    <i class="fa fa-wrench mr-1"></i> Manage
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($upcoming_bookings as $task)
                        <tr>
                            <td>
                                <a class="font-w600" href="#">{{ $task->id }}</a>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ \App\Enums\AppointmentStatus::getKey($task->status) }}</span>
                            </td>
                            <td>{{ date('d M, Y', strtotime($task->date)) }}</td>
                            <td>{{ date('h:i A', strtotime($task->time)) }}</td>
                            <td>
                                <a>{{ $task->getTasks() }} </a>
                            </td>
                            <td>
                                <span class="text-black">{{ \App\Enums\Currency::default }} {{ $task->total }}</span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-outline-secondary btn-rounded" href="{{ route('frontend.bookings.show', $task->id) }}">
                                    <i class="fa fa-wrench mr-1"></i> Manage
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">
                            <h4>
                                <span class="badge badge-danger">
                                    No Active / OnGoing Tasks
                                </span>
                            </h4>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            <!-- END Products Table -->
        </div>
    </div>


@endsection
