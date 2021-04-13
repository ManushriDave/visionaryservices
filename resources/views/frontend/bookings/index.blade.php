@extends('layouts.frontend')

@section('title', 'Bookings')

@section('head')
    @include('frontend.head.datatable')
@endsection

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Bookings <small>All</small></h3>
            <div class="ml-auto">
                <a href="{{ route('frontend.bookings.create') }}" class="btn btn-success">
                    Create New Booking
                </a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th class="d-none d-sm-table-cell">Task</th>
                    <th class="d-none d-sm-table-cell">Scheduled Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="text-center"># {{ $booking->id }}</td>
                        <td class="font-w600">{{ $booking->getTasks() }}</td>
                        <td class="d-none d-sm-table-cell">{{ \Carbon\Carbon::parse($booking->date)->toFormattedDateString() }}</td>
                        <td class="d-none d-sm-table-cell text-center">
                            <span class="badge badge-primary">
                                {{ \App\Enums\AppointmentStatus::getKey($booking->status) }}
                            </span>
                        </td>
                        <td class="text-center" style="width: 20%">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('frontend.bookings.show', $booking->id) }}" class="btn btn-sm btn-success"
                                       data-toggle="tooltip" title="View Booking">
                                        <i class="fa fa-paper-plane"></i>
                                    </a>
                                    <a href="{{ route('frontend.bookings.edit', $booking->id) }}" class="btn btn-sm btn-info"
                                       data-toggle="tooltip" title="Edit Booking">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form method="post" action="{{ route('frontend.bookings.destroy', $booking->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure, you want to cancel appointment?')"
                                                class="btn btn-sm btn-danger"
                                                data-toggle="tooltip" title="Cancel Booking">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">
                            <h4>
                                <span class="badge badge-info">
                                    No Bookings Found!
                                </span>
                            </h4>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function deleteBooking(id) {
            document.getElementById('delete-' + id).submit();
        }
    </script>
    @include('frontend.scripts.datatable')
@endsection
