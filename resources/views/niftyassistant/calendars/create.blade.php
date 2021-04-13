@extends('layouts.niftyassistant')

@section('title', 'Create Service')

@section('content')

    <div class="col-xl-8 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@yield('title')</h4>
            </div>
            <div class="card-body">
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
                    <form method="post" action="{{ route('niftyassistant.services.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Service Name</label>
                            <div class="col-sm-8">
                                <input name="name" id="name" class="form-control" placeholder="Enter Service Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="unit">Cost Unit</label>
                            <div class="col-sm-8">
                                <select id="unit" name="unit" class="form-control">
                                    @php
                                        $units = ['Hour', 'Service'];
                                    @endphp
                                    @foreach($units as $unit)
                                        <option value="{{ $unit }}">{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="cost">Cost Per Unit (in INR)</label>
                            <div class="col-sm-8">
                                <input name="cost" id="cost" class="form-control" placeholder="Enter Cost Per Unit" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Add Service</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
