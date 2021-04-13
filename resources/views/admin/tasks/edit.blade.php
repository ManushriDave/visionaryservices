@extends('layouts.admin')

@section('title', 'Edit Task : '.$task->name)

@section('content')
    <div class="col-xl-7 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit a Task</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.tasks.index', $task->assistant_type_id) }}">
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
                    <form method="post" action="{{ route('admin.tasks.update', $task->id) }}">
                        @method('patch')
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Name : </label>
                            <div class="col-sm-8">
                                <input name="assistant_type_id" type="hidden" value="{{ $task->assistant_type_id }}" readonly />
                                <input name="name" id="name" value="{{ $task->name }}" class="form-control" placeholder="Enter Task Details" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
