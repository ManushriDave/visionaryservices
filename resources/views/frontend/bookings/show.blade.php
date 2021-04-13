@extends('layouts.frontend')

@section('title', '#BOOKING_'.$booking->id)

@section('content')
    <div class="row">
        <div class="col-12 col-md-9">
            <div class="block">

                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="p-4">
                            <h4 class="my-2"> Task Booking - #{{ $booking->id }}
                            </h4>
                            <small>
                                <b>Nifty :</b>
                                @if ($booking->nifty_service_id)
                                    {{ $booking->nifty_assistant() ? $booking->nifty_assistant()->getName() : 'Not Assigned Yet!' }}
                                @else
                                    To Be Assigned!
                                @endif |
                                <b>Order date :</b> {{ date('M d, Y', strtotime($booking->created_at)) }}
                            </small>
                            <br>
                            <span class="badge badge-primary my-2">
                                {{ \App\Enums\AppointmentStatus::getKey($booking->status) }}
                            </span>
                            <a href="{{ route('frontend.bookings.edit', $booking->id) }}" class="text-dark mx-5">
                                <i class="fa fa-pencil mr-5"></i>Edit Booking
                            </a>

                        </div>
                    </div>
                    <div
                        class="col-12 col-md-4 d-flex justify-content-center align-items-center flex-column">
                        <h1 class="my-2">{{ \App\Enums\Currency::default }} {{ $booking->payment->total }}</h1>
                    </div>
                </div>
                <hr class="m-0">

                <div class="row p-4 text-center">
                    <div class="col-4">
                        <b> Scheduled Date :</b> {{ date('M d, Y', strtotime($booking->date)) }}
                    </div>
                    <div class="col-4">
                        <b>Scheduled Time :</b> {{ date('H:i A', strtotime($booking->time)) }}
                    </div>
                    <div class="col-4">
                        <b>Approx Duration (In hours) :</b> {{ $booking->approx_duration }} hrs
                    </div>
                </div>
                <hr class="m-0">

                <div class="row p-4">
                    <div class="col-12">
                        <b>Service Details : </b>
                        {!! html_entity_decode($booking->details) !!}
                    </div>
                </div>
                <div class="row p-4">
                    <div class="col-12">
                        <b>Service Documents : </b>
                        @if ($booking->documents)
                            @foreach ($booking->documents as $i => $document)
                                <button class="btn btn-alt-info ml-2" type="button" onclick="download('{{ $document->path }}')">
                                    <i class="fa fa-download mr-5"></i>{{ 'Document - '.($i+1) }}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="block">
                <div class="row p-4">
                    <div class="col-12 text-center">
                        <h4>Assigned Assistant</h4>
                        @if ($booking->nifty_service_id)
                            @php
                            $nifty_assistant = $booking->nifty_assistant();
                            @endphp
                            <img class="rounded-circle" alt="100x100"
                                 src=" {{ $nifty_assistant->avatar }}"
                                 data-holder-rendered="true" width="auto" height="100px">
                            <h5 class="mt-3 mb-0"> {{ $nifty_assistant->getName() }}</h5>
                            <small>
                                {{ $nifty_assistant->specialism }}
                                @if ($nifty_assistant->emirates)
                                | Serving Locations :
                                    @foreach($nifty_assistant->emirates as $i => $emirate)
                                        {{ $emirate->emirate->name.($i + 1 < $nifty_assistant->emirates->count() ? ', ' : '') }}
                                    @endforeach
                                @endif
                            </small>
                        @else
                            To Be Assigned!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('frontend.scripts.ckeditor')

    <!-- Page JS Plugins -->
    <script src="/assets/frontend/assets/js/plugins/jquery-raty/jquery.raty.js"></script>

    <!-- Page JS Code -->
    <script src="/assets/frontend/assets/js/pages/be_comp_rating.min.js"></script>

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
            });
        }
    </script>

@endsection
