@extends('layouts.admin')

@section('title', 'Signatures')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Signatures</h4>
            </div>
            <div class="card-body">
                <table class="table display">
                    <thead>
                        <th>Nifty</th>
                        <th>Signature</th>
                    </thead>
                    <tbody>
                        @foreach ($signatures as $signature)
                            <tr>
                                <td>{{ $signature->nifty_assistant->name }}</td>
                                <td>
                                    <form method="post" action="{{ route('admin.signatures.download', $signature->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-xs">
                                            Download Signature
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.datatable')
@endsection
