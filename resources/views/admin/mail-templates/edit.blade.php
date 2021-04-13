@extends('layouts.admin')

@section('title', 'Edit Mail Template : '.$mail_template->mail_type)

@section('content')
    <div class="col-xl-10 col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit {{ $mail_template->mail_type }} Template</h4>
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
                    <form method="post" action="{{ route('admin.mail-templates.update', $mail_template->id) }}">
                        @method('patch')
                        @include('admin.mail-templates.fields')
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Edit E-mail Content</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
