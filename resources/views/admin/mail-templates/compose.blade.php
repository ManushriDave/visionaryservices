@extends('layouts.admin')

@section('title', 'Create Mail Template')

@section('head')
    @include('admin.head.select2')
    @include('admin.head.summernote')
@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Send New Mail</h4>
                <h4 class="ml-auto">
                    <a class="btn btn-info" href="{{ route('admin.mail-templates.index') }}">
                        Back
                    </a>
                </h4>
            </div>
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
                <div class="basic-form">
                    <form method="post" action="{{ route('admin.mail-templates.send') }}">
                        <div class="form-group">
                            <label>Select Niftys <span class="text-danger">*</span></label>
                            <select class="select-2" name="nifty_ids[]" multiple>
                                <option value="0">All Nifties</option>
                                @foreach($nifties as $nifty)
                                    <option value="{{ $nifty->id }}"
                                            @if (isset($_GET['nifty_id']) && in_array((string) $nifty->id, explode(',', $_GET['nifty_id']))) selected @endif>
                                        {{ $nifty->name .' - ' . $nifty->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="email_template_id">Select Email Template <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="email_template_id" id="email_template_id" class="select-2 w-100" required>
                                    <option value="0">Compose New Email</option>
                                    @foreach($mail_templates as $template)
                                        <option value="{{ $template->id }}">
                                            @if ($template->mail_type === App\Enums\MailType::CUSTOM)
                                                {{ $template->subject }}
                                            @else
                                                {{ App\Enums\MailType::getDescription((int) $template->mail_type) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="reason">Reason (ONLY FOR ON-HOLD AND REJECTED NIFTY)</label>
                            <div class="col-sm-10">
                                <input name="reason" class="form-control" placeholder="Enter Reason" id="reason">
                            </div>
                        </div>
                        <div id="hide">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="subject">Subject <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input name="subject" class="form-control" placeholder="Enter E-mail Subject" id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="content">Content <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea name="content" rows="5" class="summernote" id="content">@include('admin.mail-templates.mail-template')</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Send E-mail</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.select2')
    @include('admin.scripts.summernote')
    <script>
        let elt = $('#hide');
        $(".select-2").select2();
        $(document).on('change', '#email_template_id', function () {
            if ($(this).val() === '{{ App\Enums\MailType::NEW_EMAIL }}') {
                elt.show();
            } else {
                elt.hide();
            }
        });
        $('.summernote').summernote({
            height: 600,
        })
    </script>
@endsection
