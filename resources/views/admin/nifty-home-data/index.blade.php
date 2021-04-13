@extends('layouts.admin')

@section('title', 'Assistant Types')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Niftys Home Data</h4>
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
                        <th>Background Image</th>
                        <th>Icon</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($niftys_home_data)
                            @foreach($niftys_home_data as $nifty_home_data)
                                <tr>
                                    <td>{{ $nifty_home_data->assistant_type->name }}</td>
                                    <td>{{ $nifty_home_data->bg_img }}</td>
                                    <td>{{ $nifty_home_data->icon }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.nifty-home-data.edit', $nifty_home_data->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
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
        function delete_assistant_type(id) {
            if (confirm('Are you sure you want to delete this Assistant Type?')) {
                document.getElementById('delete-' + id).submit();
            }
        }
    </script>
    @include('admin.scripts.datatable')
@endsection
