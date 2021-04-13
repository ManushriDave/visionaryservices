@extends('layouts.admin')

@section('title', 'Tasks')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tasks for {{ $assistant_type->name }}</h4>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a class="btn btn-primary" href="{{ route('admin.tasks.create', $assistant_type->id) }}">
                        Add New Task
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example5" class="display">
                        <thead>
                        <th>Task</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($tasks)
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form method="post" id="{{ 'delete-'.$task->id }}" action="{{ route('admin.tasks.destroy', $task->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="button" onclick="deleteTask({{ $task->id }})"
                                                        class="btn btn-danger shadow btn-xs sharp">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            </a>
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
    <script>
        function deleteTask(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                document.getElementById('delete-' + id).submit();
            }
        }
    </script>
    @include('admin.scripts.datatable')
@endsection
