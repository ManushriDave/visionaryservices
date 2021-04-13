@extends('layouts.niftyassistant')

@section('title', 'My Services')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')


    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">My Services</h4>
                <a href="{{ route('niftyassistant.services.create') }}" class="btn btn-primary ml-auto">
                    Add A Service
                </a>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table class="table" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Service For</th>
                            <th>Cost </th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>
                                    @if($service->assistant_type)
                                        {{$service->assistant_type->name}}
                                    @else
                                        <span class="label label-danger">Action Required (Edit to Change)</span>
                                    @endif
                                </td>
                                <td>{{ $service->cost.' '.\App\Enums\Currency::default.' / '.$service->unit }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-primary shadow btn-xs sharp mr-1" href="{{ route('niftyassistant.services.edit', $service->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="post" action="{{ route('niftyassistant.services.destroy', $service->id) }}">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Are you sure?')" type="submit">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    <span class="label label-danger">
                                        No Services Yet!
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
    <script>
        $('.table').DataTable({
            'order': [[0, 'asc']]
        })
    </script>
@endsection
