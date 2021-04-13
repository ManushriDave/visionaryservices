@extends('layouts.frontend')

@section('title', 'Edit Booking')

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
                        Edit Booking
                    </h5>
                </div>
                <div class="block-content">

                    <form method="post" action="{{ route('frontend.bookings.update', $booking->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Appointment Date</label>
                            <div class="col-sm-9">
                                <input name="date" class="js-flatpickr form-control bg-white" placeholder="Enter Appointment Date"
                                       value="{{ $booking->date }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Appointment Time</label>
                            <div class="col-sm-9">
                                <input name="time" class="js-flatpickr form-control bg-white form-control" placeholder="Enter Appointment Time"
                                       value="{{ $booking->time }}" data-enable-time="true" data-no-calendar="true" data-date-format="H:i" data-time_24hr="false" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Approx. Task Duration</label>
                            <div class="col-sm-9">
                                <input name="approx_duration" class="js-flatpickr form-control bg-white form-control" placeholder="Enter Appointment Time"
                                       value="{{ $booking->approx_duration }}" data-enable-time="true" data-no-calendar="true" data-date-format="H" data-time_24hr="true" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Task Details</label>
                            <div class="col-sm-9">
                                <textarea id="js-ckeditor" name="details" required>{!! html_entity_decode($booking->details) !!}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3">Documents:</label>
                            <div class="col-8">
                                @if ($booking->documents)
                                    @foreach ($booking->documents as $i => $document)
                                        <li>
                                            <a class="btn btn-sm btn-primary m-2"
                                               href="{{ route('frontend.bookings.download', [$document->path, '']) }}"
                                               target="_blank"
                                            >
                                                {{ 'Document - '.($i+1) }}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <h5>N/A</h5>
                                @endif
                                <div class="custom-file">
                                    <input type="file" name="document_files[]" class="custom-file-input" multiple
                                           id="example-file-multiple-input-custom" data-toggle="custom-file-input">
                                    <label class="custom-file-label" for="example-file-multiple-input-custom">Choose Documents</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Update Booking</button>
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
