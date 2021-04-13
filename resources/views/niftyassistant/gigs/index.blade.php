@extends('layouts.niftyassistant')
@section('title', 'Profile')
@section('head')
    <link href="/assets/common/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        @foreach($gigs as $gig)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-primary d-inline">Gig For {{ $gig->assistant_type->name }}</h5><br>
                        <small>This is how your profile would be available to clients.</small>
                        <hr>
                        <div class="col-12">
                            <div class="card no-rad">
                                <!-- slider -->
                                <div id="slideNifty{{ $gig->id }}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @forelse($gig->resources as $resource)
                                            @if($loop->first)
                                                @php
                                                    $class = 'active';
                                                @endphp
                                            @else
                                                @php
                                                    $class = '';
                                                @endphp
                                            @endif
                                            <div class="carousel-item {{ $class }}">
                                                @if (pathinfo($resource->file, PATHINFO_EXTENSION) === 'mp4')
                                                    <video class="d-block w-100" height="145" controls autoplay>
                                                        <source src="{{ $resource->file }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <img class="d-block mx-auto" style="height: 145px" src="{{ $resource->file }}" alt="Resource #{{ $resource->id }}" />
                                                @endif
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <a class="carousel-control-prev" href="#slideNifty{{ $gig->id }}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#slideNifty{{ $gig->id }}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <!-- slider end -->

                                <div class="card-body p-2">
                                    <div class="inner-top mt-2 row">
                                        <div class="col-3">
                                            <img class="rounded-circle p-1 w-100"
                                                 src="{{ $gig->nifty->avatar }}"
                                                 alt="Profile Image">
                                            <span class="is-online"></span>
                                        </div>
                                        <div class="seller-identifiers col-9">
                                            <div class="seller-name">
                                                <a href="#" rel="nofollow noopener noreferrer" target="_self">{{ $gig->nifty->name }}</a>
                                            </div>
                                            <span class="bottom-level">{{ $gig->assistant_type->name }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="text-title p-2">
                                        <a href="javascript:void(0)">{{ $gig->about_me }} </a>
                                    </div>
                                    <span class="star-rate gold"> <i class="icon-star fa fa-star"></i>
                                <small  class="text-muted  pl-1">({{ $gig->nifty->review_string }})</small>
                            </span>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="price-footer">
                                        <small class="text-body-3">Starting at</small>
                                        <span id="price">
                                        @if ($gig->nifty->cheapestService($gig->assistant_type->id))
                                            {{ \App\Enums\Currency::default }}
                                                {{ $gig->nifty->cheapestService($gig->assistant_type->id)->cost }} /
                                                {{ $gig->nifty->cheapestService($gig->assistant_type->id)->unit }}
                                        @else
                                            N/A
                                        @endif
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Gig</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ route('niftyassistant.gigs.update', $gig->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="pt-4 border-bottom-1 pb-3">
                                            <h4 class="text-primary">About Me</h4>
                                            <textarea class="form-control" name="about_me"
                                                      placeholder="Tell your clients something about you.">{{ $gig->about_me }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm mb-2">Update</button>
                                    </form>
                                    <hr>

                                    <div class="profile-personal-info mt-4">
                                        <h4 class="text-primary">Add Images / Videos for thi gig (Multiple Allowed)</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="post" enctype="multipart/form-data" action="{{ route('niftyassistant.gigs.update', $gig->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="update_type" value="{{ \App\Enums\ProfileUpdateType::ADD_RESOURCES }}" />
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input form-control" name="resources_files[]" multiple required>
                                                            <label class="custom-file-label">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button name="resources" class="btn btn-primary" type="submit">Add Resources</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @php
                                                        $resources_size = 0;
                                                    @endphp
                                                    @forelse($gig->resources as $resource)
                                                        {{ $gig->resources->sum('size') }}
                                                        <div class="col-2">
                                                            <div class="mt-2 text-center">
                                                                @if (pathinfo($resource->file, PATHINFO_EXTENSION) === 'mp4')
                                                                    <video class="m-2 w-100" src="{{ $resource->file }}"></video>
                                                                @else
                                                                    <img class="m-2 w-100" src="{{ $resource->file }}" alt="Resource #{{ $resource->id }}" />
                                                                @endif
                                                                <form method="post" action="{{ route('niftyassistant.gigs.update', $gig->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="resource_id" value="{{ $resource->id }}" />
                                                                    <input type="hidden" name="update_type" value="{{ \App\Enums\ProfileUpdateType::REMOVE_RESOURCES }}" />
                                                                    <button type="submit" name="resources" class="btn btn-danger shadow btn-xs sharp text-center"
                                                                            onclick="return confirm('Are you sure, you want to delete it?')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="col-12">
                                                            <div class="alert alert-danger mt-2">
                                                                <strong>No Resources Uploaded Yet!</strong>
                                                                Upload resources so that client gets to know your skills!
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                    <div class="col-12">
                                                        <hr>
                                                        <div class="alert alert-info text-center">
                                                            Please note that you can upload resources upto 10 MB. <br>
                                                            Current Resource Size : <strong>{{ $resources_size }} MB</strong>
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
                </div>
            </div>
        @endforeach
    </div>
@endsection
