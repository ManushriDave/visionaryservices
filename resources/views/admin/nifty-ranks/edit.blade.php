@extends('layouts.admin')

@section('title', 'Edit Nifty Rank : '.$nifty_rank->name)

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Nifty Rank</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.nifty-ranks.index') }}">
                        Back
                    </a>
                </h4>
            </div>
            <div class="card-body">
                @include('flash::message')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="basic-form">
                    <form method="post" action="{{ route('admin.nifty-ranks.update', $nifty_rank->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" id="name">Nifty Rank Name</label>
                            <div class="col-sm-8">
                                <input name="name" value="{{ $nifty_rank->name }}" class="form-control" placeholder="Enter Package Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" id="commission">Commission</label>
                            <div class="col-sm-8">
                                <input name="commission" value="{{ $nifty_rank->commission }}" class="form-control" placeholder="Enter Commission" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit Nifty Rank</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
