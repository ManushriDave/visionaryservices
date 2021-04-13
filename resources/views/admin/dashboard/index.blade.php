@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #BF934C" class="widget-stat card primary">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-file-alt"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Appointments</p>
                                    <h3 class="text-white">{{ $appointments->count() }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #1B1612" class="widget-stat card danger">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-dollar"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Revenue</p>
                                    <h3 class="text-white">{{ \App\Enums\Currency::default }} {{ $total_revenue }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #BF934C" class="widget-stat card primary">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-file-alt"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Cost </p>
                                    <h3 class="text-white">{{ \App\Enums\Currency::default }} {{ $total_cost }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #1B1612" class="widget-stat card info">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-file-alt"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Net</p>
                                    <h3 class="text-white">{{ \App\Enums\Currency::default }} {{ $total_net }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #1B1612" class="widget-stat card warning">
                        <div class="card-body p-4">
                            <div class="media mt-2">
									<span class="mr-3">
										<i class="la la-user"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Assistants</p>
                                    <h3 class="text-white">{{ $nifty_assistants->count() }}</h3>
                                    <div class="progress mb-2 bg-primary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #BF934C" class="widget-stat card dark">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-file-alt"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Pending Appointments</p>
                                    <h3 class="text-white">{{ $pending_appointments->count() }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #1B1612" class="widget-stat card blue-dark">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-file-alt"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Pending Assistants</p>
                                    <h3 class="text-white">{{ $pending_assistants->count() }}</h3>
                                    <div class="progress mb-2 bg-secondary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div style="background-color: #BF934C" class="widget-stat card secondary">
                        <div class="card-body p-4">
                            <div class="media mt-3">
									<span class="mr-3">
										<i class="la la-users"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Total Clients</p>
                                    <h3 class="text-white">{{ $clients->count() }}</h3>
                                    <div class="progress mb-2 bg-primary">
                                        <div class="progress-bar bg-light" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title"> Types Tasks Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="assistants_type_chart" class="morris_chart_height"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Location Wise Tasks Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="locations_tasks_chart" class="morris_chart_height"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Gender Wise Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="gender_chart" class="morris_chart_height"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Age Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="age_chart" class="morris_chart_height"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Skills Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="skill_chart" class="morris_chart_height"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title">Top Client</h4>
                        </div>
                        @if ($top_client)
                            <div class="text-center p-5 overlay-box" style="background-image: url(/assets/common/images/big/img5.jpg);">
                                <img src="/assets/common/images/profile/profile.png" width="196" class="img-fluid rounded-circle" alt="">
                                <h3 class="mt-3 mb-0 text-white">{{ $top_client->name }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="bgl-primary rounded p-3">
                                            <h4 class="mb-0">Appointments: {{ $top_client->appointments->count() }}</h4>
                                            <small>Successful</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <span class="badge badge-danger">Not Available</span>
                            </div>
                        @endif
                    </div>
                </div> -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.morris')
    @include('admin.scripts.chart-js')
    <script>
        $(document).ready(function () {
            const screenWidth = $(window).width();

            const setChartWidth = function(){
                if(screenWidth <= 768)
                {
                    let chartBlockWidth = 0;
                    chartBlockWidth = (screenWidth < 300 )?screenWidth:300;
                    $.each($('.morris_chart_height'), function () {
                        $(this).css('min-width', chartBlockWidth - 31);
                    })
                }
            }

            const tasksChart = function(){
                Morris.Donut({
                    element: 'assistants_type_chart',
                    data: {!! json_encode($appointments_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: [
                        @for($i = 0; $i < count($appointments_graph); $i++)
                            '{{ random_color() }}',
                        @endfor
                    ],
                    responsive:true,

                });
            }

            const locationsTasksChart = function () {
                Morris.Donut({
                    element: 'locations_tasks_chart',
                    data: {!! json_encode($locations_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: [
                        @for($i = 0; $i < count($locations_graph); $i++)
                            '{{ random_color() }}',
                        @endfor
                    ],
                    responsive:true,
                });
            }

            const genderChart = function () {
                Morris.Donut({
                    element: 'gender_chart',
                    data: {!! json_encode($gender_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: ['#BF934C', '#1b1612'],
                    responsive:true,
                });
            }

            const nationalityChart = function () {
                Morris.Donut({
                    element: 'nationality_chart',
                    data: {!! json_encode($nationality_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: [
                        @for($i = 0; $i < count($nationality_graph); $i++)
                            '{{ random_color() }}',
                        @endfor
                    ],
                    responsive:true,
                });
            }

            const ageChart = function () {
                Morris.Donut({
                    element: 'age_chart',
                    data: {!! json_encode($age_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: [
                        @for($i = 0; $i < count($age_graph); $i++)
                            '{{ random_color() }}',
                        @endfor
                    ],
                    responsive:true,
                });
            }

            const skillChart = function () {
                Morris.Donut({
                    element: 'skill_chart',
                    data: {!! json_encode($nifty_skills_graph, JSON_PRETTY_PRINT) !!},
                    resize: true,
                    redraw: true,
                    colors: [
                        @for($i = 0; $i < count($nifty_skills_graph); $i++)
                            '{{ random_color() }}',
                        @endfor
                    ],
                    responsive:true,
                });
            }

            @if ($monthly_sales)
            //gradient bar chart
            const barChart_2 = document.getElementById("barChart_2").getContext('2d');
            //generate gradient
            const barChart_2gradientStroke = barChart_2.createLinearGradient(0, 0, 0, 250);
            barChart_2gradientStroke.addColorStop(0, "rgba(191, 147, 76, 1)");
            barChart_2gradientStroke.addColorStop(1, "rgba(191, 147, 76, 0.5)");

            barChart_2.height = 100;

            new Chart(barChart_2, {
                type: 'bar',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels: [
                        @foreach ($monthly_sales['month'] as $monthly_sale)
                            '{{ $monthly_sale }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            data: [
                                @foreach ($monthly_sales['data'] as $monthly_sale)
                                    {{ $monthly_sale.', ' }}
                                @endforeach
                            ],
                            borderColor: barChart_2gradientStroke,
                            borderWidth: "0",
                            backgroundColor: barChart_2gradientStroke,
                            hoverBackgroundColor: barChart_2gradientStroke
                        }
                    ]
                },
                options: {
                    legend: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            // Change here
                            barPercentage: 0.5
                        }]
                    }
                }
            });


            //gradient bar chart
            const barChart_3 = document.getElementById("barChart_3").getContext('2d');
            //generate gradient
            const barChart_3gradientStroke = barChart_3.createLinearGradient(0, 0, 0, 250);
            barChart_3gradientStroke.addColorStop(0, "rgba(191, 147, 76, 1)");
            barChart_3gradientStroke.addColorStop(1, "rgba(191, 147, 76, 0.5)");

            barChart_3.height = 100;

            new Chart(barChart_3, {
                type: 'bar',
                data: {
                    defaultFontFamily: 'Poppins',
                    labels: [
                        @foreach ($monthly_costs['month'] as $monthly_cost)
                            '{{ $monthly_cost }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            data: [
                                @foreach ($monthly_costs['data'] as $monthly_cost)
                                    {{ $monthly_cost.', ' }}
                                @endforeach
                            ],
                            borderColor: barChart_2gradientStroke,
                            borderWidth: "0",
                            backgroundColor: barChart_2gradientStroke,
                            hoverBackgroundColor: barChart_2gradientStroke
                        }
                    ]
                },
                options: {
                    legend: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            // Change here
                            barPercentage: 0.5
                        }]
                    }
                }
            });
            @endif

            setChartWidth();
            tasksChart();
            locationsTasksChart();
            genderChart();
            nationalityChart();
            ageChart();
            skillChart();
        })
    </script>
@endsection
