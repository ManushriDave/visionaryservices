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
                <h4 class="card-title">Create New Mail Template</h4>
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
                    <form method="post" action="{{ route('admin.mail-templates.store') }}">
                        @include('admin.mail-templates.fields')
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Create E-mail Template</button>
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
        $(document).on('change', '#email_template', function () {
            if ($(this).val() === '5') {
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
