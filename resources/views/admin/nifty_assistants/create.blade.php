@extends('layouts.admin')

@section('title', 'Assistants')

@section('head')
    <link href="/css/jquery.schedule.min.css" rel="stylesheet" />
@endsection

@section('content')


    <div class="card bg-white shadow-lg border-0">
        <div class="card-body">
            <div class="row justify-content-center py-2">
                <div class="col-11">
                    <form id="register_form" class="row" method="post" enctype="multipart/form-data" novalidate="novalidate">
                        <div class="form-process">
                            <div class="css3-spinner">
                                <div class="css3-spinner-scaler"></div>
                            </div>
                        </div>
                        <div class="col-6 form-group mt-3">
                            <label>First Name:</label>
                            <input type="text" name="first_name" class="form-control required" placeholder="Enter your First Name" />
                        </div>
                        <div class="col-6 form-group mt-3">
                            <label>Last Name:</label>
                            <input type="text" name="last_name" class="form-control required" placeholder="Enter your Last Name" />
                        </div>
                        <div class="col-md-4 form-group mt-3">
                            <label>Gender:</label>
                            <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                <label class="btn btn-outline-secondary ls0 nott">
                                    <input type="radio" name="gender" id="jobs-application-gender-male"
                                           autocomplete="off" value="0" />
                                    Male
                                </label>
                                <label class="btn btn-outline-secondary ls0 nott">
                                    <input type="radio" name="gender" id="jobs-application-gender-female"
                                           autocomplete="off" value="1" />
                                    Female
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 form-group mt-3">
                            <label>Date Of Birth:</label>
                            <input type="date" name="dob" class="form-control dobpicker required" placeholder="MM/DD/YYYY"
                                   data-date-end-date="-18y">
                        </div>
                        <div class="col-md-4 form-group mt-3">
                            <label>Nationality:</label>
                            <input type="text" name="nationality" class="form-control required" placeholder="Enter your nationality">
                        </div>
                        <div class="col-md-12 form-group mt-3">
                            <label>Languages Known:</label>
                            <input type="text" name="known_languages" class="form-control required" placeholder="languages you know">
                        </div>
                        <div class="col-6 form-group mt-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control required" placeholder="Enter your Email" />
                        </div>
                        <div class="col-md-6 form-group mt-3">
                            <label>Phone:</label>
                            <input type="text" name="phone" class="form-control required" placeholder="Enter your Phone" />
                        </div>
                        <div class="col-md-6 form-group mt-3">
                            <label>Do you have UAE driving license :</label>
                            <select name="has_driving_licence" class="form-control required">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group mt-3">
                            <label>
                                Do you have your own transportation :</label>
                            <select name="has_own_transportation" class="form-control required">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>


                        <div class="col-md-12 form-group mt-3">
                            <label>
                                Please select your availability :</label>
                            <h5>
                                <span class="badge badge-warning">
                                  Tip :  To select multiple times, you may click and drag from top to bottom.
                                </span>
                            </h5>
                            <div class="availability" id="availability"></div>
                        </div>

                        <div class="col-md-12 form-group mt-3">
                            <label>Experience as Personal Assistant :</label>
                            <select name="experience" class="form-control required">
                                <option value="0">0 years</option>
                                <option value="1-3">1 - 3 years</option>
                                <option value="4+">4+ years</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group mt-3">
                            <label>Personal Assistant field (select more than one if necessary applicable) :</label>
                            <div>
                                <input id="checkbox-1" class="checkbox-style" name="checkbox[]" type="checkbox"
                                       value="IP, CEO, Top executive Personal/Executive assistant">
                                <label for="checkbox-1" class="checkbox-style-3-label">VIP, CEO, Top executive
                                    Personal/Executive assistant</label>
                            </div>
                            <div>
                                <input id="checkbox-2" class="checkbox-style" name="checkbox[]" type="checkbox"
                                       value="Admin Assistant/Secretary">
                                <label for="checkbox-2" class="checkbox-style-3-label">Admin Assistant/Secretary</label>
                            </div>
                            <div>
                                <input id="checkbox-3" class="checkbox-style" name="checkbox[]" type="checkbox"
                                       value="PRO/Government relations/Visas/Immigration">
                                <label for="checkbox-3" class="checkbox-style-3-label">PRO/Government
                                    relations/Visas/Immigration</label>
                            </div>
                            <div>
                                <input id="checkbox-4" class="checkbox-style" name="checkbox[]" type="checkbox" value="Errand runner">
                                <label for="checkbox-4" class="checkbox-style-3-label">Errand runner</label>
                            </div>
                            <div>
                                <input id="checkbox-5" class="checkbox-style" name="checkbox[]" type="checkbox"
                                       value="Care assistant/Nurse/Healthcare Related">
                                <label for="checkbox-5" class="checkbox-style-3-label">Care assistant/Nurse/Healthcare
                                    Related</label>
                            </div>
                            <!-- file upload -->
                            <div>
                                <div class="col-lg-6 mt-3 mb-5 ">
                                    <label>Upload your CV</label><br>
                                    <div class="file-input file-input-new">
                                        <div class="kv-upload-progress kv-hidden" style="display: none;">
                                            <div class="progress">
                                                <div
                                                    class="progress-bar bg-success progress-bar-success progress-bar-striped active"
                                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 0%;">
                                                    0%
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="input-group file-caption-main">
                                            <div class="file-caption form-control kv-fileinput-caption" tabindex="500">
                                                <span class="file-caption-icon"></span>
                                                <input class="file-caption-name" placeholder="Select file ...">
                                            </div>
                                            <div class="input-group-btn input-group-append">
                                                <button type="button" tabindex="500" title="Clear all unprocessed files"
                                                        class="btn btn-default btn-secondary fileinput-remove fileinput-remove-button"><i
                                                        class="glyphicon glyphicon-trash"></i> <span
                                                        class="hidden-xs">Remove</span></button>
                                                <button type="button" tabindex="500" title="Abort ongoing upload"
                                                        class="btn btn-default btn-secondary kv-hidden fileinput-cancel fileinput-cancel-button"><i
                                                        class="glyphicon glyphicon-ban-circle"></i> <span
                                                        class="hidden-xs">Cancel</span></button>

                                                <button type="submit" tabindex="500" title="Upload selected files"
                                                        class="btn btn-default btn-secondary fileinput-upload fileinput-upload-button"><i
                                                        class="glyphicon glyphicon-upload"></i> <span
                                                        class="hidden-xs">Upload</span></button>
                                                <div tabindex="500" class="btn btn-primary btn-file"><i
                                                        class="glyphicon glyphicon-folder-open"></i>&nbsp; <span
                                                        class="hidden-xs">Browse …</span>
                                                    <input id="input-1" type="file" name="cv_file" class="file" data-show-preview="false">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End upload -->

                            <div class="col-12 text-center">
                                <button class="btn btn-dark btn-lg px-5 submit-application"> Submit Application </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="/js/jquery.schedule.min.js"></script>
    <script>

        const baseUrl = '{{ config('app.url') }}';

        $(document).ready(function() {

            $('#availability').jqs({
                mode: 'edit',
                hour: 12,
                days: 7,
                periodDuration: 60,
                data: [],
                periodOptions: true,
            });

            $(document).on('click', '.submit-application', function(e) {
                e.preventDefault();

                let formData = new FormData($('#register_form')[0]);

                let availability = $('#availability').jqs('export');
                formData.append('availability', availability);

                $.ajax({
                    type        : "POST",
                    cache       : false,
                    processData : false,
                    contentType : false,
                    url         : baseUrl + '/api/nifty_assistant/register',
                    data        : formData,
                    success     : function(data) {
                        if (data) {
                            console.log(data);
                        }
                    },
                })
            });

        });
    </script>
@endsection
