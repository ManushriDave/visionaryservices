@extends('layouts.admin')

@section('title', 'Edit Nifty Home Data : '.$nifty_home_data->assistant_type->name)

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit a Nifty Home Data</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.nifty-home-data.index') }}">
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
                    <form method="post" action="{{ route('admin.nifty-home-data.update', $nifty_home_data->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="bg_img">Background Image : </label>
                            <div class="col-sm-8">
                                <input name="bg_img" id="bg_img" value="{{ $nifty_home_data->bg_img }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="icon">Nifty Icon : </label>
                            <div class="col-sm-8">
                                <input name="icon" id="icon" value="{{ $nifty_home_data->icon }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit Nifty Home Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
