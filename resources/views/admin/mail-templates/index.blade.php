@extends('layouts.admin')

@section('title', 'Nifty Mail Templates')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Mail Templates</h4>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <a class="btn btn-primary" href="{{ route('admin.mail-templates.create') }}">
                        Create New Template
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('flash::message')
                <div class="table-responsive">
                    <table id="example5" class="display">
                        <thead>
                        <th>Email Type</th>
                        <th>Subject</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        @if($mail_templates)
                            @foreach($mail_templates as $mail_template)
                                <tr>
                                    <td>{{ App\Enums\MailType::getDescription((int) $mail_template->mail_type) }}</td>
                                    <td>{{ $mail_template->subject }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.mail-templates.edit', $mail_template->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form method="post" action="{{ route('admin.mail-templates.destroy', $mail_template->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Email?')"
                                                        class="btn btn-danger shadow btn-xs sharp">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('admin.scripts.datatable')
@endsection
