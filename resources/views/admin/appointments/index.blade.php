@extends('layouts.admin')

@section('title', 'Appointments')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Appointments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example5" class="display" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Task</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->user->name }}</td>
                                <td>{{ $appointment->user->email }}</td>
                                <td>{{ $appointment->getTasks() }}</td>
                                <td>{{ date('d M, Y', strtotime($appointment->date)) }}</td>
                                <td>{{ date('h:i A', strtotime($appointment->time)) }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('admin.appointments.show', $appointment->id) }}">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    <span class="label label-danger">
                                        No Appointments Yet!
                                    </span>
                                </td>
                            </tr>
                        @endforelse
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
