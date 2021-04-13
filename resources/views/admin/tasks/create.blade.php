@extends('layouts.admin')

@section('title', 'Create Task')

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add a Task for {{ $assistant_type->name }}</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.tasks.index', $assistant_type->id) }}">
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
                    <form method="post" action="{{ route('admin.tasks.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Name : </label>
                            <div class="col-sm-8">
                                <input name="name" id="name" class="form-control" placeholder="Enter Task Details" required>
                            </div>
                        </div>

                        <input name="assistant_type_id" type="hidden" value="{{ $assistant_type->id }}" readonly />

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Add Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
