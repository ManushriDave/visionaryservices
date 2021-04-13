@extends('layouts.admin')

@section('title', 'View an Appointment')

@section('head')
    @include('admin.head.select2')
    @include('admin.head.material_datetime')
    @include('admin.head.summernote')
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Appointment: # {{ $appointment->id }}</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.appointments.index') }}">
                        Back
                    </a>
                </h4>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="row">
                    <div class="col-md-6">
                        <div class="basic-form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Client : </label>
                                <div class="col-sm-9">
                                    <input class="form-control" value="{{ $appointment->user->name }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Assistant Type : </label>
                                <div class="col-sm-9">
                                    <input class="form-control"
                                           value="{{ $appointment->appointment_tasks->first()->task->assistant_type->name }}"
                                           disabled
                                    />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Task</label>
                                <div class="col-sm-9">
                                    <input class="form-control" value="{{ $appointment->getTasks() }}" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Appointment Date</label>
                                <div class="col-sm-9">
                                    <input value="{{ $appointment->date }}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Appointment Time</label>
                                <div class="col-sm-9">
                                    <input value="{{ $appointment->time }}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Approx. Job Duration</label>
                                <div class="col-sm-9">
                                    <input value="{{ $appointment->approx_duration }}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Task Extra Details</label>
                                <div class="col-sm-9">
                                    <div class="summernote">{!! html_entity_decode($appointment->details) !!}</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Assigned Nifty Assistant</label>
                                <div class="col-sm-9">
                                    @if ($appointment->nifty_assistant_id)
                                        <input value="{{ $appointment->nifty_assistant->getName() }}" class="form-control" disabled>
                                        <label class="mt-2">Change Nifty Assistant : </label>
                                    @endif
                                    <form method="post" action="{{ route('admin.appointments.update', $appointment->id) }}">
                                        @csrf
                                        @method('patch')
                                        <select name="nifty_assistant_id" class="mr-sm-2 select-2" id="single-select" required>
                                            <option selected>Choose a Nifty Assistant</option>
                                            @if($nifty_assistants)
                                                @foreach($nifty_assistants as $nifty_assistant)
                                                    <option value="{{ $nifty_assistant->id }}">{{ $nifty_assistant->getName() }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="submit" class="btn btn-success mt-3">Assign Nifty Assistant</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Appointment Timeline</h4>
                        </div>
                        <div class="card-body">
                            <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1" style="height:250px;">
                                <ul class="timeline">
                                    @if($appointment->timeline)
                                        @foreach($appointment->timeline as $tl)
                                            <li>
                                                <div class="timeline-badge primary"></div>
                                                <h6 class="timeline-panel text-muted" href="#">
                                                    {!! html_entity_decode($tl) !!}
                                                </h6>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.select2')
    @include('admin.scripts.material_datetime')
    @include('admin.scripts.summernote')
    <script>
        const summernote = $('.summernote');
        summernote.summernote({
            toolbar: [],
        });
        summernote.summernote('disable');
    </script>
@endsection
