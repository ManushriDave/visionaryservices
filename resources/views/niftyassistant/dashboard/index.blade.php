@extends('layouts.niftyassistant')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-xl-9 col-xxl-12">
            <div class="row">
                <!-- wid -->
                <div class="col-lg-4 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                        <span class="mr-3">
                          <!-- <i class="ti-user"></i> -->
                          <svg
                              id="icon-customers"
                              xmlns="http://www.w3.org/2000/svg"
                              width="30"
                              height="30"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="feather feather-user"
                          >
                            <path
                                d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                style="
                                stroke-dasharray: 25px, 45px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                            <path
                                d="M8,7A4,4 0,1,1 16,7A4,4 0,1,1 8,7"
                                style="
                                stroke-dasharray: 26px, 46px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                          </svg>
                        </span>
                                <div class="media-body">
                                    <p class="mb-1">Completed Tasks</p>
                                    <h4 class="mb-0">{{ $completed_tasks->count() }}</h4>
                                    <!-- <span class="badge badge-primary">+3.5%</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                        <span class="mr-3">
                          <svg
                              id="icon-orders"
                              xmlns="http://www.w3.org/2000/svg"
                              width="30"
                              height="30"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="feather feather-file-text"
                          >
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                style="
                                stroke-dasharray: 66px, 86px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                            <path
                                d="M14,2L14,8L20,8"
                                style="
                                stroke-dasharray: 12px, 32px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                            <path
                                d="M16,13L8,13"
                                style="
                                stroke-dasharray: 8px, 28px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                            <path
                                d="M16,17L8,17"
                                style="
                                stroke-dasharray: 8px, 28px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                            <path
                                d="M10,9L9,9L8,9"
                                style="
                                stroke-dasharray: 2px, 22px;
                                stroke-dashoffset: 0px;
                              "
                            ></path>
                          </svg>
                        </span>
                                <div class="media-body">
                                    <p class="mb-1">Pending Tasks</p>
                                    <h4 class="mb-0">{{ $pending_tasks->count() }}</h4>
                                    <!-- <span class="badge badge-warning">+3.5%</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <div class="media ai-icon">
                                <span class="mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="20.5" cy="12.5" r="1.5"/>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 6.500000) rotate(-15.000000) translate(-12.000000, -6.500000) " x="3" y="3" width="18" height="7" rx="1"/>
                                            <path d="M22,9.33681558 C21.5453723,9.12084552 21.0367986,9 20.5,9 C18.5670034,9 17,10.5670034 17,12.5 C17,14.4329966 18.5670034,16 20.5,16 C21.0367986,16 21.5453723,15.8791545 22,15.6631844 L22,18 C22,19.1045695 21.1045695,20 20,20 L4,20 C2.8954305,20 2,19.1045695 2,18 L2,6 C2,4.8954305 2.8954305,4 4,4 L20,4 C21.1045695,4 22,4.8954305 22,6 L22,9.33681558 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="media-body">
                                    <p class="mb-1">Total Earnings</p>
                                    <h4 class="mb-0">INR {{ $earned_amount }}</h4>
                                    <!-- <span class="badge badge-danger">-3.5%</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wid end -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 pb-0">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">My Tasks</h4>
                        </div>
                        <div class="card-body">
                            @if($pending_tasks || $accepted_tasks)
                            @foreach ($pending_tasks as $task)
                                <div class="overlay-box mt-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-12 align-self-center mt-3">
                                            <div class="text-center">
                                                <img
                                                    src="/assets/common/images/client.png"
                                                    class="img-fluid rounded-circle"
                                                    alt=""
                                                    width="100"
                                                />
                                                <h3 class="mt-3 mb-0 text-white">
                                                    {{ $task->user->name }}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-12 align-self-center">
                                            <div class="row p-4">
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Task</h5>
                                                        <h4 class="mb-0">{{ $task->getTasks() }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Scheduled Time</h5>
                                                        <h4 class="mb-0">{{ date('h:i A', strtotime($task->time)) }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Scheduled Date</h5>
                                                        <h4 class="mb-0">{{ date('d M, Y', strtotime($task->date)) }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Status</h5>
                                                        <h4 class="mb-0">
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Est. Amount</h5>
                                                        <h4 class="mb-0">{{ \App\Enums\Currency::default }} {{ $task->payment->total }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <a href="{{ route('niftyassistant.tasks.show', $task->id) }}"
                                                           class="btn btn-block btn-primary mb-0">
                                                            View Task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            @foreach ($accepted_tasks as $task)
                                <div class="overlay-box mt-3">
                                    <div class="row">
                                        <div class="col-lg-3 col-12 align-self-center mt-3">
                                            <div class="text-center">
                                                <img
                                                    src="/assets/common/images/client-1.png"
                                                    class="img-fluid rounded-circle"
                                                    alt=""
                                                    width="100"
                                                />
                                                <h3 class="mt-3 mb-0 text-white">
                                                    {{ $task->user->name }}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-12 align-self-center">
                                            <div class="row p-4">
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Task</h5>
                                                        <h4 class="mb-0">{{ $task->getTasks() }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Scheduled Time</h5>
                                                        <h4 class="mb-0">{{ date('h:i A', strtotime($task->time)) }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Scheduled Date</h5>
                                                        <h4 class="mb-0">{{ date('d M, Y', strtotime($task->date)) }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Status</h5>
                                                        <h4 class="mb-0">
                                                            <span class="badge badge-success">
                                                                Accepted
                                                            </span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <h5>Est. Amount</h5>
                                                        <h4 class="mb-0">{{ \App\Enums\Currency::default }} {{ $task->payment->total }}</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-6 col-12 mt-3">
                                                    <div class="bgl-primary rounded p-3">
                                                        <a href="{{ route('niftyassistant.tasks.show', $task->id) }}"
                                                           class="btn btn-block btn-primary mb-0">
                                                            View Task
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Recent Completed Tasks</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm mb-0">
                                    <thead>
                                    <tr>
                                        <th><strong>NAME</strong></th>
                                        <th><strong>DATE</strong></th>
                                        <th><strong>STATUS</strong></th>
                                        <th><strong>Amount</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($completed_tasks as $task)

                                            <tr>
                                                <td>{{ $task->user->name }}</td>
                                                <td>{{ date('d M, Y', strtotime($task->date)) }}</td>
                                                <td
                                                    class="recent-stats d-flex align-items-center"
                                                >
                                                    <i class="fa fa-circle text-success mr-1"></i
                                                    >Successful
                                                </td>
                                                <td><b>{{ \App\Enums\Currency::default }} {{ $task->payment->total }}</b></td>
                                            </tr>
                                        @empty

                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    <h3>
                                                        <span class="badge badge-danger">
                                                            No Tasks Completed Yet!
                                                        </span>
                                                    </h3>
                                                </td>
                                            </tr>

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
