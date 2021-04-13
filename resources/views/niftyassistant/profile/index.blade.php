@extends('layouts.niftyassistant')
@section('title', 'Profile')
@section('head')
    <link href="/assets/common/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <style>
        .close-me {
            text-align: center !important;
            padding: 5px;
            color: red !important;
            font-size: 13px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ $nifty->avatar }}" class="img-fluid rounded-circle" alt="">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{ $nifty->name }}</h4>
                                <p>{{ $nifty->specialism }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
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
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#about-me" data-toggle="tab" class="nav-link active show">About Me</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="about-me" class="tab-pane fade active show">
                                    <div class="profile-lang mt-4 mb-5">
                                        <h4 class="text-primary mb-2">Languages Known</h4>
                                        @php
                                            $known_languages = explode(', ', $nifty->known_languages)
                                        @endphp
                                        @foreach($known_languages as $language)
                                            <a href="javascript:void(0)" class="text-muted pr-3 f-s-16"><i class="flag-icon flag-icon-us"></i>
                                                {{ $language }}
                                            </a>
                                        @endforeach
                                        {{--<select class="form-control" multiple></select>--}}
                                    </div>
                                    <div class="profile-personal-info">
                                        <h4 class="text-primary mb-4">Personal Information</h4>
                                        <div class="row mb-2">
                                            <div class="col-3">
                                                <h5 class="f-w-500">Name <span class="pull-right">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-9"><span>{{ $nifty->full_name }} <img id="country_image" src="" alt="{{ $nifty->nationality }}"/> </span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-3">
                                                <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-9"><span>{{ $nifty->email }}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-3">
                                                <h5 class="f-w-500">Age <span class="pull-right">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-9"><span>{{ \Carbon\Carbon::parse($nifty->dob)->age }} years</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-3">
                                                <h5 class="f-w-500">Location <span class="pull-right">:</span></h5>
                                            </div>
                                            <div class="col-9">
                                                <textarea class="form-control nifty_location w-75" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="profile-settings" class="tab-pane fade">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <h4 class="text-primary">Account Settings</h4>
                                            <form method="post" action="{{ route('niftyassistant.profile.update', $nifty->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="update_type" value="{{ \App\Enums\ProfileUpdateType::NORMAL }}">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" placeholder="Email" value="{{ $nifty->email }}" name="email" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Change Password</label>
                                                        <input type="password" name="password" placeholder="Enter New Password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="phone">Phone</label>
                                                        <input id="phone" name="phone" type="tel" placeholder="999999999" value="{{ $nifty->phone }}" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="known_languages">Languages Known</label>
                                                        <input id="known_languages" name="known_languages" type="text" value="{{ $nifty->known_languages }}" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="avatar">Edit Profile Avatar</label>
                                                        <input id="avatar" type="file" class="form-control" />
                                                        <input name="avatar" type="hidden" />
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="autocomplete_search">Location</label>
                                                        <input type="hidden" id="lat" name="lat">
                                                        <input type="hidden" id="long" name="long">
                                                        <input type="text" id="autocomplete_search" placeholder="Type to change Your Location" class="form-control nifty_location">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <div style="height: 200px; " class="mt-3" id="map"></div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Please Crop Image Before Uploading.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/assets/common/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcKwLbp_jiv72njmaMCwf5y5dQBkI67rY&libraries=places&v=weekly"></script>
    <script>
        $.get('https://maps.googleapis.com/maps/api/geocode/json?latlng={{ $nifty->lat }},{{ $nifty->long }}&key={{ config('app.maps_api_key') }}').then(
            res => {
                $('.nifty_location').val(res.results[0].formatted_address);
            }
        )
        $.get('https://api.first.org/data/v1/countries?q={{ $nifty->nationality }}').then(res => {
            for(var a in res.data) {
                $('#country_image').attr('src', 'https://www.countryflags.io/' + a + '/flat/32.png');
            }
        })
        const map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: {{ $nifty->lat }},
                lng: {{ $nifty->long }},
            },
            zoom: 15,
        });
        const marker = new google.maps.Marker({
            map,
            position: {
                lat: {{ $nifty->lat }},
                lng: {{ $nifty->long }},
            },
        });

        function initialize() {
            let input = document.getElementById('autocomplete_search');
            let autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                let place = autocomplete.getPlace();
                let name = input.value;
                if(name.length > 60) {
                    input.value = name.substring(0, 60) + " ...";
                }
                // place variable will have all the information you are looking for.
                document.getElementById('lat').value = place.geometry['location'].lat();
                document.getElementById('long').value = place.geometry['location'].lng();
                $('#map').css('display', 'block');

                setTimeout(() => {
                    const map = new google.maps.Map(document.getElementById("map"), {
                        center: place.geometry.location,
                        zoom: 15,
                    });
                    const marker = new google.maps.Marker({
                        map,
                        position: place.geometry.location,
                    });
                    google.maps.event.addListener(marker, "click", () => {
                        infowindow.setContent(place.name);
                        infowindow.open(map);
                    });
                }, 500);
            });
        }

        function showPosition(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('long').value = position.coords.longitude;
            $('#map').css('display', 'block');
            let autocomplete_input = document.getElementById('autocomplete_search');
            const _googleApiGeocoder = new google.maps.Geocoder();
            _googleApiGeocoder.geocode({
                location: {
                    lat: parseFloat(position.coords.latitude),
                    lng: parseFloat(position.coords.longitude)
                }
            }, (results_, status_) => {
                if(status_ !== google.maps.GeocoderStatus.OK) {
                    alert('Something went wrong while searching your location!');
                } else {
                    let place = results_[0];
                    autocomplete_input.value = place.formatted_address;
                    setTimeout(() => {
                        const map = new google.maps.Map(document.getElementById("map"), {
                            center: place.geometry.location,
                            zoom: 15,
                        });
                        const marker = new google.maps.Marker({
                            map,
                            position: place.geometry.location,
                        });
                        google.maps.event.addListener(marker, "click", () => {
                            infowindow.setContent(place.name);
                            infowindow.open(map);
                        });
                    }, 500);
                }
            });
        }

        function getLocation() {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }


        let $modal = $('#modal');
        let image = document.getElementById('image');
        let cropper;

        $("body").on("change", "#avatar", function(e){
            let files = e.target.files;
            let done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            let reader;
            let file;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                let reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    let base64data = reader.result;

                    $('input[name="avatar"]').val(base64data);
                    $modal.modal('hide');
                }
            });
        })

        $(document).ready(function () {
            google.maps.event.addDomListener(window, 'load', initialize());

            $(document).on('change', 'select', function (){
                let val = $(this).val();
                $(this).find('option[value="'+ val +'"]').attr('selected', 'selected');
            })

            $.each($('[data-toggle="popover"]'), function () {
                $(this).popover();
                let elt = $(this).data('elt');
                $(this).attr(
                    'data-content',
                    '@for ($i = 0; $i <= 6; $i++) <a class="copy ' + elt + '" id="day-{{ $i }}" href="#copy">{{ days_array()[$i] }}</a> <br> @endfor <a class="close-me">Close</a>'
                )
            });


            $(document).on('click', '.copy', function (e) {
                e.preventDefault();
                $('.select-elt').selectpicker('destroy');
                let dayId = $(this).attr('id');
                let dayElement = $("#" + dayId);
                let classes = $(this).attr('class');
                let eltId = classes.toString().replace('copy ', '');
                let newClass = '.toCopy-day-' + eltId;

                let parentElt = $(newClass);

                let class_array = $(".toAdd-" + dayId + ':last').attr('class').split(' ');

                let copy_class_array = class_array[2].split('-');

                let newCopyElt = copy_class_array[2];

                copy_class_array[3] = (Number(copy_class_array[3]) + 1).toString();
                newCopyElt = newCopyElt + '-' + copy_class_array[3];
                let copy_class = copy_class_array.join('-');

                let add_class = class_array[1];

                let clone = parentElt.clone().attr('class', 'row ' + add_class + ' ' + copy_class);

                let copyBtn = clone.children().last().children().last();
                copyBtn.attr('data-elt', newCopyElt);
                copyBtn.attr(
                    'data-content',
                    '@for ($i = 0; $i <= 6; $i++) <a class="copy ' + newCopyElt + '" id="day-{{ $i }}" href="#copy">{{ days_array()[$i] }}</a> <br> @endfor <a class="close-me">Close</a>'
                )

                let selectFromElt = clone.children().first().find('select:first');
                let selectFromEltArray = selectFromElt.attr('name').split('_');
                selectFromEltArray[1] = dayId.split('-')[1];
                selectFromElt.attr('name', selectFromEltArray.join('_'));

                let selectToElt = clone.children().first().find('select:last');
                let selectToEltArray = selectToElt.attr('name').split('_');
                selectToEltArray[1] = dayId.split('-')[1];
                selectToElt.attr('name', selectToEltArray.join('_'));

                dayElement.append(clone);
                $('.toCopy').popover();
                $('.select-elt').selectpicker('refresh');
            })

            $(document).on('click', '.add', function () {
                $('.select-elt').selectpicker('destroy');
                let dayId = $(this).data('day');
                let dayElement = $("#" + dayId);

                let class_array = $(".toAdd-" + dayId + ':last').attr('class').split(' ');

                let copy_class_array = class_array[2].split('-');

                let newCopyElt = copy_class_array[2];

                copy_class_array[3] = (Number(copy_class_array[3]) + 1).toString();
                newCopyElt = newCopyElt + '-' + copy_class_array[3];
                let copy_class = copy_class_array.join('-');

                let add_class = class_array[1];

                let clone = $('.toAdd-' + dayId + ':first').clone().attr('class', 'row ' + add_class + ' ' + copy_class);
                let copyBtn = clone.children().last().children().last();
                copyBtn.attr('data-elt', newCopyElt);
                copyBtn.attr(
                    'data-content',
                    '@for ($i = 0; $i <= 6; $i++) <a class="copy ' + newCopyElt + '" id="day-{{ $i }}" href="#copy">{{ days_array()[$i] }}</a> <br> @endfor'
                )
                dayElement.append(clone);
                $('.toCopy').popover();
                $('.select-elt').selectpicker('refresh');
            })

            $(document).on('click', '.remove', function () {
                let element = $(this).closest('div').parent();
                if (element.parent().children().length > 1) {
                    element.remove();
                }
            })

            $(document).on('click', '.close-me', function () {
                $.each($('.popover'), function () {
                    if ($(this).hasClass('show')) {
                        $(this).removeClass('show');
                    }
                })
            })
        });
    </script>
@endsection
