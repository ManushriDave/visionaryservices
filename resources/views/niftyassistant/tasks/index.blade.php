@extends('layouts.niftyassistant')

@section('title', 'My Tasks')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Tasks</h4>
            </div>
            <div class="card-body">
                @include('flash::message')
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
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->user->name }}</td>
                                <td>{{ $task->user->email }}</td>
                                <td>{{ $task->getTasks() }}</td>
                                <td>{{ date('d M, Y', strtotime($task->date)) }}</td>
                                <td>{{ date('h:i A', strtotime($task->time)) }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('niftyassistant.tasks.show', $task->id) }}">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    <span class="label label-danger">
                                        No Tasks Yet!
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
