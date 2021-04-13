@extends('layouts.niftyassistant')

@section('title', 'My Calendar')

@section('head')
    @include('admin.head.datatable')
    <link href="/assets/common/vendor/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include('flash::message')
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <strong>You may block the time for a particular period of time if you have any personal matter.</strong>
                                    Just drag and select the time you are offline for.
                                </div>
                                <div id="calendar" class="app-fullcalendar"></div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN MODAL -->
                    <div class="modal fade none-border" id="event-modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="event-form">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><strong>Event Information</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="work" class="control-label">Describe about this matter in short : </label>
                                                <input id="work" class="form-control form-white" type="text" name="work">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success save-event waves-effect waves-light">Create
                                            event</button>

                                        <button type="button" id="delete-event" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add Category -->
                    <div class="modal fade none-border" id="add-category">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><strong>Add a category</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label">Category Name</label>
                                                <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Choose Category Color</label>
                                                <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                                    <option value="success">Success</option>
                                                    <option value="danger">Danger</option>
                                                    <option value="info">Info</option>
                                                    <option value="pink">Pink</option>
                                                    <option value="primary">Primary</option>
                                                    <option value="warning">Warning</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
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
    <script src="/assets/common/vendor/jqueryui/js/jquery-ui.min.js"></script>
    <script src="/assets/common/vendor/moment/moment.min.js"></script>

    <script src="/assets/common/vendor/fullcalendar/js/fullcalendar.min.js"></script>
    @include('niftyassistant.calendars.scripts')
@endsection
