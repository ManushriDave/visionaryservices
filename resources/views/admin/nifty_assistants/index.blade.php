@extends('layouts.admin')

@section('title', 'Nifties')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')

    <div class="col-12">
        <div class="row">
            <div class="col-lg-6 text-center mx-auto">
                @include('flash::message')
            </div>
        </div>
        <div class="custom-tab-1 card">
            <div class="card-header">
                <h4 class="card-title">Assistants</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs card-body-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pending">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#approved">Approved</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#on_hold">On Hold</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#rejected">Rejected</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <div class="pt-4">
                            <div class="table-responsive">
                                <button id="email-all-0" class="btn btn-info btn-xs mb-2 pull-right">Email Selected </button>
                                <table class="table table0" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registered On</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Nationality</th>
                                        <th>Last Communication</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($pending_nifty_assistants as $i => $nifty_assistant)
                                        <tr>
                                            <td>{{ $nifty_assistant->id }}</td>
                                            <td>{{ $nifty_assistant->first_name.' '.$nifty_assistant->last_name }}</td>
                                            <td>{{ $nifty_assistant->email }}</td>
                                            <td>{{ $nifty_assistant->created_at->toFormattedDateString() }}</td>
                                            <td>{{ $nifty_assistant->phone }}</td>
                                            <td>{{ \App\Enums\Gender::getKey($nifty_assistant->gender) }}</td>
                                            <td>{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse($nifty_assistant->dob)) }}</td>
                                            <td>{{ $nifty_assistant->nationality }}</td>
                                            <td>{{ $nifty_assistant->interview ? $nifty_assistant->interview->date : 'N/A' }}</td>
                                            <td>
                                                <form method="post" action="{{ route('admin.nifty_assistants.destroy', $nifty_assistant->id) }}">
                                                    <div class="btn-group mb-2 btn-group-sm">
                                                        <a class="btn btn-primary btn-sm"
                                                           href="{{ route('admin.nifty_assistants.show', $nifty_assistant->id) }}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit"
                                                                onclick="return confirm('Are you sure, you want to delete this nifty?')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <a class="btn btn-info" href="{{ route('admin.mail-templates.compose', ['nifty_id' => $nifty_assistant->id]) }}">
                                                            <i class="fa fa-envelope"></i>
                                                        </a>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="9">
                                                <span class="label label-danger">
                                                    No Assistants Requests Pending!
                                                </span>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="approved" role="tabpanel">
                        <div class="pt-4">
                            <button id="email-all-1" class="btn btn-info btn-xs mb-2 pull-right">Email Selected </button>
                            <table class="table table1" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Nationality</th>
                                    <th>Last Communication</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($approved_nifty_assistants as $nifty_assistant)
                                    <tr>
                                        <td>{{ $nifty_assistant->id }}</td>
                                        <td>{{ $nifty_assistant->first_name.' '.$nifty_assistant->last_name }}</td>
                                        <td>{{ $nifty_assistant->email }}</td>
                                        <td>{{ $nifty_assistant->created_at->toFormattedDateString() }}</td>
                                        <td>{{ $nifty_assistant->phone }}</td>
                                        <td>{{ \App\Enums\Gender::getKey($nifty_assistant->gender) }}</td>
                                        <td>{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse($nifty_assistant->dob)) }}</td>
                                        <td>{{ $nifty_assistant->nationality }}</td>
                                        <td>{{ $nifty_assistant->interview ? $nifty_assistant->interview->date : 'N/A' }}</td>
                                        <td>
                                            <form method="post" action="{{ route('admin.nifty_assistants.destroy', $nifty_assistant->id) }}">
                                                <div class="btn-group mb-2 btn-group-sm">
                                                    <a class="btn btn-primary btn-sm"
                                                       href="{{ route('admin.nifty_assistants.show', $nifty_assistant->id) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure, you want to delete this nifty?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <a class="btn btn-info" href="{{ route('admin.mail-templates.compose', ['nifty_id' => $nifty_assistant->id]) }}">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <span class="label label-danger">
                                                No Assistants Yet!
                                            </span>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="on_hold" role="tabpanel">
                        <div class="pt-4">
                            <button id="email-all-2" class="btn btn-info btn-xs mb-2 pull-right">Email Selected </button>
                            <table class="table table2 table-striped" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Nationality</th>
                                    <th>Last Communication</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($on_hold_nifty_assistants as $nifty_assistant)
                                    <tr>
                                        <td>{{ $nifty_assistant->id }}</td>
                                        <td>{{ $nifty_assistant->first_name.' '.$nifty_assistant->last_name }}</td>
                                        <td>{{ $nifty_assistant->email }}</td>
                                        <td>{{ $nifty_assistant->created_at->toFormattedDateString() }}</td>
                                        <td>{{ $nifty_assistant->phone }}</td>
                                        <td>{{ \App\Enums\Gender::getKey($nifty_assistant->gender) }}</td>
                                        <td>{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse($nifty_assistant->dob)) }}</td>
                                        <td>{{ $nifty_assistant->nationality }}</td>
                                        <td>{{ $nifty_assistant->interview ? $nifty_assistant->interview->date : 'N/A' }}</td>
                                        <td>
                                            <form method="post" action="{{ route('admin.nifty_assistants.destroy', $nifty_assistant->id) }}">
                                                <div class="btn-group mb-2 btn-group-sm">
                                                    <a class="btn btn-primary btn-sm"
                                                       href="{{ route('admin.nifty_assistants.show', $nifty_assistant->id) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure, you want to delete this nifty?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <a class="btn btn-info" href="{{ route('admin.mail-templates.compose', ['nifty_id' => $nifty_assistant->id]) }}">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rejected" role="tabpanel">
                        <div class="pt-4">
                            <button id="email-all-3" class="btn btn-info btn-xs mb-2 pull-right">Email Selected </button>
                            <table class="table table3 table-striped" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Nationality</th>
                                    <th>Last Communication</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rejected_nifty_assistants as $nifty_assistant)
                                    <tr>
                                        <td>{{ $nifty_assistant->id }}</td>
                                        <td>{{ $nifty_assistant->first_name.' '.$nifty_assistant->last_name }}</td>
                                        <td>{{ $nifty_assistant->email }}</td>
                                        <td>{{ $nifty_assistant->created_at->toFormattedDateString() }}</td>
                                        <td>{{ $nifty_assistant->phone }}</td>
                                        <td>{{ \App\Enums\Gender::getKey($nifty_assistant->gender) }}</td>
                                        <td>{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::parse($nifty_assistant->dob)) }}</td>
                                        <td>{{ $nifty_assistant->nationality }}</td>
                                        <td>{{ $nifty_assistant->interview ? $nifty_assistant->interview->date : 'N/A' }}</td>
                                        <td>
                                            <form method="post" action="{{ route('admin.nifty_assistants.destroy', $nifty_assistant->id) }}">
                                                <div class="btn-group mb-2 btn-group-sm">
                                                    <a class="btn btn-primary btn-sm"
                                                       href="{{ route('admin.nifty_assistants.show', $nifty_assistant->id) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure, you want to delete this nifty?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <a class="btn btn-info" href="{{ route('admin.mail-templates.compose', ['nifty_id' => $nifty_assistant->id]) }}">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('admin.scripts.datatable')
    <script>
        @for($i = 0; $i < 4; $i++)
        let table{{ $i }} = $('.table{{ $i }}').DataTable({
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            'order': [[3, 'asc']]
        });


        $('#email-all-{{ $i }}').on('click', function () {
            let rows_selected = table{{ $i }}.column(0).checkboxes.selected();
            window.location.href = '{{ config('app.url') }}/admin/mail-templates/compose?nifty_id=' + rows_selected.join(",");
        })
        @endfor
    </script>
@endsection
