@extends('layouts.admin')

@section('title', 'Edit Assistant Type : '.$assistant_type->name)

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Assistant Type</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.assistant_types.index') }}">
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
                    <form method="post" action="{{ route('admin.assistant_types.update', $assistant_type->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" id="name">Assistant Type Name</label>
                            <div class="col-sm-8">
                                <input name="name" value="{{ $assistant_type->name }}" class="form-control" placeholder="Enter Assistant Type Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit Assistant Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
