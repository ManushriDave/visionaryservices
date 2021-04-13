@extends('layouts.admin')

@section('title', 'View Assistant')

@section('head')
    <!-- Material color picker -->
    <link href="/assets/common/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    @include('admin.head.datatable')
@endsection

@section('content')

    <div class="card bg-white shadow-lg border-0">
        <div class="card-body">
            <div class="row justify-content-center py-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 text-center mx-auto">
                            @include('flash::message')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-lg-9 mx-auto">
                            <h4 class="mr-auto">
                                <a class="btn btn-info" href="{{ route('admin.nifty_assistants.index') }}">
                                    Back
                                </a>
                            </h4>
                            <div class="col-lg-6 text-center mx-auto mb-2">
                                <h5>
                                    <span class="badge badge-info">{{ \App\Enums\NiftyStatus::getKey((int) $nifty_assistant->status) }} </span>
                                </h5>
                            </div>
                            <div class="card overflow-hidden">
                                <div class="text-center p-3 overlay-box">
                                    <div class="profile-photo">
                                        <img src="{{ $nifty_assistant->avatar }}" width="100" class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <h5 class="text-white mb-0"> <b>{{ $nifty_assistant->name }}</b></h5>
                                </div>
                                <div class="row">
                                    @include('admin.nifty_assistants.actions')
                                    <div class="col-md-12">
                                        <table class="table table-striped w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="font-w600">Email :</td>
                                                    <td>
                                                        <b>{{ $nifty_assistant->email }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Phone :</td>
                                                    <td>
                                                        <b>{{ $nifty_assistant->phone }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Specialism :</td>
                                                    <td>
                                                        <b>{{ $nifty_assistant->specialism }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Tasks Selected :</td>
                                                    <td>
                                                        @foreach ($nifty_assistant->specialities as $speciality)
                                                            {{ $speciality->task->name.', ' }}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Age : </td>
                                                    <td>
                                                        <b>{{ \Carbon\Carbon::parse($nifty_assistant->dob)->age }} years </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Gender : </td>
                                                    <td>
                                                        <b>
                                                            {{ \App\Enums\Gender::getKey($nifty_assistant->gender) }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                @if ($nifty_assistant->emirates)
                                                <tr>
                                                    <td class="font-w600">Emirate : </td>
                                                    <td>
                                                        @foreach($nifty_assistant->emirates as $i => $emirate)
                                                        <b>
                                                            {{ $emirate->emirate->name }}{{ $i < count($nifty_assistant->emirates) - 1 ? ',' : '' }}
                                                        </b>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td class="font-w600">Nationality : </td>
                                                    <td>
                                                        <b>
                                                            {{ $nifty_assistant->nationality }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Languages Known : </td>
                                                    <td>
                                                        <b>
                                                            {{ $nifty_assistant->known_languages }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Driving Licence : </td>
                                                    <td>
                                                        <b>
                                                            {{ $nifty_assistant->has_driving_licence ? 'Yes' : 'No' }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-w600">Own transportation : </td>
                                                    <td>
                                                        <b>
                                                            {{ $nifty_assistant->has_own_transportation ? 'Yes' : 'No' }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                @if ($nifty_assistant->private)
                                                <tr>
                                                    <td class="font-w600">Source : </td>
                                                    <td>
                                                        <b>
                                                            {{ $nifty_assistant->private->source }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('admin.scripts.datatable')
    <!-- Material color picker -->

    <!-- momment js is must -->
    <script src="/assets/common/vendor/moment/moment.min.js"></script>
    <script src="/assets/common/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script>
        $('#interview_date').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });
    </script>
@endsection
