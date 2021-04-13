@extends('layouts.admin')

@section('title', 'Nifty Ranks')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Ranks</h4>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a class="btn btn-primary" href="{{ route('admin.nifty-ranks.create') }}">
                        Add New Rank
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example5" class="display">
                        <thead>
                        <th>Rank</th>
                        <th>Commission (in %)</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($nifty_ranks)
                            @foreach($nifty_ranks as $nifty_rank)
                                <tr>
                                    <td>{{ $nifty_rank->name }}</td>
                                    <td>{{ $nifty_rank->commission }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.nifty-ranks.edit', $nifty_rank->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form method="post" id="{{ 'delete-'.$nifty_rank->id }}"
                                                  action="{{ route('admin.nifty-ranks.destroy', $nifty_rank->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Assistant Type?')"
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
    @include('admin.scripts.datatable')
@endsection
