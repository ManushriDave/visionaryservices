@extends('layouts.niftyassistant')

@section('title', 'Service : '.$service->name)

@section('content')

    <div class="col-xl-8 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Service: {{ $service->name }}</h4>
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
                    <form method="post" action="{{ route('niftyassistant.services.update', $service->id) }}">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Service Name</label>
                            <div class="col-sm-8">
                            <input name="name" id="name" class="form-control" placeholder="Enter Service Name" value="{{ $service->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="unit">Service Unit</label>
                            <div class="col-sm-8">
                                <select id="unit" name="unit" class="form-control">
                                    @php
                                    $units = ['Hour', 'Service'];
                                    @endphp
                                    @foreach($units as $unit)
                                        @if ($unit === $service->unit)
                                            <option value="{{ $unit }}" selected>{{ $unit }}</option>
                                        @else
                                            <option value="{{ $unit }}">{{ $unit }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="cost">Cost Per Unit (in INR)</label>
                            <div class="col-sm-8">
                                <input name="cost" id="cost" class="form-control" value="{{ $service->cost }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit Service</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
