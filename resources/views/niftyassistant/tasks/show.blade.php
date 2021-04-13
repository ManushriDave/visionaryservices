@extends('layouts.niftyassistant')

@section('title', 'Task : #'.$task->id)

@section('content')

    <div class="col-xl-8 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Task: # {{ $task->id }}</h4>
            </div>
            <div class="card-body">
                @if($task->status === \App\Enums\AppointmentStatus::getValue('ACCEPTED'))
                    <h3 class="text-center">
                        <span class="badge badge-success">
                            ACCEPTED!
                        </span>
                    </h3>
                    <hr>
                @endif
                <div class="basic-form">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Client : </label>
                        <div class="col-sm-9">
                            {{ $task->user->name }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Task Details : </label>
                        <div class="col-sm-9">
                            {!! html_entity_decode($task->details) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Task Categories</label>
                        <div class="col-sm-9">
                            {{ $task->getTasks() }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Appointment Date</label>
                        <div class="col-sm-9">
                            {{ date('d M, Y', strtotime($task->date)) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Appointment Time</label>
                        <div class="col-sm-9">
                            {{ date('h:i A', strtotime($task->time)) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Approx. Job Duration</label>
                        <div class="col-sm-9">
                            Min {{ $task->approx_duration }} Hours
                        </div>
                    </div>

                    @if($task->status === \App\Enums\AppointmentStatus::PENDING)
                        <div class="form-group">
                            <form id="form" class="row" method="post" action="{{ route('niftyassistant.tasks.update', $task->id) }}">
                                @csrf
                                @method('patch')
                                <div class="col-lg-3 col-sm-6">
                                    <button class="btn btn-success w-100 mt-2" type="submit">
                                        Accept Task
                                    </button>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <button name="reject" class="btn btn-danger w-100 mt-2" type="submit">
                                        Reject Task
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="col-12">
                            <b>Service Documents : </b>
                            @if ($task->documents)
                                @foreach ($task->documents as $i => $document)
                                    <button class="btn btn-info ml-2" type="button" onclick="download('{{ $document->path }}')">
                                        <i class="fa fa-download mr-1"></i>{{ 'Document - '.($i+1) }}
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>

        function download(file) {
            $.ajax({
                type: 'POST',
                url: '{{ route('frontend.bookings.download') }}',
                data: {
                    'file': file,
                    '_token': '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response){
                    const blob = new Blob([response]);
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = file.split('/').pop();
                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            })
        }
    </script>

@endsection
