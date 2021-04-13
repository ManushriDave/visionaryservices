@section('head')
    @include('admin.head.summernote')
    @include('admin.head.select2')
@endsection

@csrf
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="subject">Subject <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <input name="subject" value="{{ isset($mail_template) ? $mail_template->subject : '' }}" class="form-control" placeholder="Enter E-mail Heading" id="subject" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="content">Content <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <textarea name="content" rows="5" class="summernote" id="content">@if(isset($mail_template)) {!! $mail_template->content !!} @else @include('admin.mail-templates.mail-template') @endif</textarea>
    </div>
</div>
@section('scripts')
    @include('admin.scripts.summernote')
    @include('admin.scripts.select2')
    <script>
        $(".select-2").select2();
        $('.summernote').summernote({
            height: 600
        })
    </script>
@endsection
