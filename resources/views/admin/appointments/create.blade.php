@extends('layouts.admin')

@section('title', 'Add an Appointment')

@section('head')
    @include('admin.head.select2')
    @include('admin.head.material_datetime')
@endsection

@section('content')
    <div class="col-xl-8 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add an Appointment</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.appointments.index') }}">
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
                    <form method="post" action="{{ route('admin.appointments.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select a Client : </label>
                            <div class="col-sm-9">
                                <select name="user_id" class="mr-sm-2 select-2" id="single-select" required>
                                    <option selected>Choose a Client</option>
                                    @if($users)
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select Assistant Type : </label>
                            <div class="col-sm-9">
                                <select name="assistant_type_id" class="mr-sm-2 select-2" id="single-select" required>
                                    @foreach ($assistant_types as $assistant_type)
                                        <option value="{{ $assistant_type->id }}">
                                            {{ App\Enums\AssistantType::getKey($assistant_type->id) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select a Task</label>
                            <div class="col-sm-9">

                                <select name="task_id" class="mr-sm-2 select-2" id="single-select" required>
                                    <option selected>Choose a Task</option>
                                    @if($tasks)
                                        @foreach($tasks as $task)
                                            <option value="{{ $task->id }}">{{ $task->details }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Appointment Date</label>
                            <div class="col-sm-9">
                                <input name="date" class="form-control" id="mdate" placeholder="Enter Appointment Date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Appointment Time</label>
                            <div class="col-sm-9">
                                <input name="time" class="form-control timepicker" placeholder="Enter Appointment Time" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Approx. Job Duration</label>
                            <div class="col-sm-9">
                                <input name="approx_duration" class="form-control timepicker" placeholder="Enter Approximate Job Duration" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Task Extra Details</label>
                            <div class="col-sm-9">
                                <textarea name="extra_details" class="form-control" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Add Appointment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.select2')
    @include('admin.scripts.material_datetime')
@endsection
