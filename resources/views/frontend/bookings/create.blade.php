@extends('layouts.frontend')

@section('title', 'Create New Booking')

@section('head')
    @include('frontend.head.select2')
    @include('frontend.head.flatpickr')
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="block">
                <div class="block-header-default">
                    <h5 class="block-header">
                        Book an Appointment / Task
                    </h5>
                </div>
                <div class="block-content">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </div>
                    @endif
                    <form method="post" action="{{ route('frontend.bookings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="assistant_type_id">Select Nifty Assistant Type : </label>
                            <div class="col-sm-9">
                                <select name="assistant_type_id" id="assistant_type_id" class="js-select2 form-control" required>
                                    @foreach ($assistant_types as $assistant_type)
                                        @if(isset($redirect_data))
                                            @if(intval($redirect_data->assistant_type_id) === $assistant_type->id)
                                                <option value="{{ $assistant_type->id }}" selected>
                                                    {{ $assistant_type->name }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $assistant_type->id }}">
                                                {{ $assistant_type->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="task_ids">Select a Task</label>
                            <div class="col-sm-9">
                                <select name="task_ids[]" id="task_ids" class="js-select2 form-control" required multiple>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="emirate_id">Select Your City</label>
                            <div class="col-sm-9">

                                <select name="emirate_id" class="js-select2 form-control" id="emirate_id" required>
                                    <option selected>Choose a City</option>
                                    @if($emirates)
                                        @foreach($emirates as $emirate)
                                            <option value="{{ $emirate->id }}">{{ $emirate->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="date">Appointment Date</label>
                            <div class="col-sm-9">
                                <input name="date" id="date" class="js-flatpickr form-control bg-white" placeholder="Enter Appointment Date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="time">Appointment Time</label>
                            <div class="col-sm-9">
                                <input name="time" id="time" class="js-flatpickr form-control bg-white form-control" placeholder="Enter Appointment Time"
                                       data-enable-time="true" data-no-calendar="true" data-date-format="H:i" data-time_24hr="false" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="approx_duration">
                                Estimated Task Duration
                            </label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="css-control css-control-sm css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="approx_duration" value="1">
                                            <span class="css-control-indicator"></span> Small - Est. 1 hr
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="css-control css-control-sm css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="approx_duration" value="3" checked>
                                            <span class="css-control-indicator"></span> Medium - Est. 2-3 hrs
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="css-control css-control-sm css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="approx_duration" value="23">
                                            <span class="css-control-indicator"></span> Large - Est. 4+ hrs
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="approx_duration">
                                Vehicle Needed for Task?
                            </label>
                            <div class="col-sm-9">
                                <label class="css-control css-control-sm css-control-info css-radio">
                                    <input type="radio" class="css-control-input" name="vehicle_needed">
                                    <span class="css-control-indicator"></span> Yes
                                </label>
                                <label class="css-control css-control-sm css-control-info css-radio">
                                    <input type="radio" class="css-control-input" name="vehicle_needed" checked>
                                    <span class="css-control-indicator"></span> No
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="js-ckeditor">Task Details</label>
                            <div class="col-sm-9">
                                <textarea id="js-ckeditor" name="details" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Documents (if any)</label>
                            <div class="col-8">
                                <div class="custom-file">
                                    <input type="file" name="document_files[]" class="custom-file-input" multiple
                                           id="example-file-multiple-input-custom" data-toggle="custom-file-input">
                                    <label class="custom-file-label" for="example-file-multiple-input-custom">Choose Documents</label>
                                </div>
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
    @include('frontend.scripts.select2')
    @include('frontend.scripts.flatpickr')
    @include('frontend.scripts.ckeditor')
    @include('frontend.bookings.scripts')
@endsection
