@extends('layouts.admin')

@section('title', 'Assistant Types')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Assistant Types</h4>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a class="btn btn-primary" href="{{ route('admin.assistant_types.create') }}">
                        Add New Assistant Type
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example5" class="display">
                        <thead>
                        <th>Assistant Type</th>
                        <th>Tasks</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($assistant_types)
                            @foreach($assistant_types as $assistant_type)
                                <tr>
                                    <td>{{ $assistant_type->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.tasks.index', $assistant_type->id) }}">
                                            Manage Tasks
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.assistant_types.edit', $assistant_type->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form method="post" id="{{ 'delete-'.$assistant_type->id }}"
                                                  action="{{ route('admin.assistant_types.destroy', $assistant_type->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="button" onclick="delete_assistant_type({{ $assistant_type->id }})"
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
    <script>
        function delete_assistant_type(id) {
            if (confirm('Are you sure you want to delete this Assistant Type?')) {
                document.getElementById('delete-' + id).submit();
            }
        }
    </script>
    @include('admin.scripts.datatable')
@endsection
