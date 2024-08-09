@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h6 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard</h6>

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-8 space-y-4">
            <div class="overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                <div class="inline-flex items-center space-x-4">
                    <img class="h-12 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::User()->name) }}&background=0D8ABC&color=fff&bold=true"
                        alt="{{ Auth::User()->name }} avatar" />

                    <div class="space-y-2">
                        <div class="text-sm font-semibold text-gray-700 dark:text-white">
                            Welcome, {{ auth()->user()->name }}
                        </div>
                        <a href="{{ route('auth.logout') }}"
                            class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                            data-modal-target="resolve-assignment-modal"
                            data-modal-show="resolve-assignment-modal">
                            <svg class="me-1 h-3.5 w-3.5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                            </svg>

                            Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bar Charts -->
            <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                    <div class="flex items-center">
                        <div
                            class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                            <svg class="h-6 w-6 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 19">
                                <path
                                    d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z" />
                                <path
                                    d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ $total_assignment_last_week }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Assignment in last 7 days</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2">
                    <dl class="flex items-center">
                        <dt class="me-1 text-sm font-normal text-gray-500 dark:text-gray-400">Resolved overall score:</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $total_score ?? 0 }}%</dd>
                    </dl>
                    <dl class="flex items-center justify-end">
                        <dt class="me-1 text-sm font-normal text-gray-500 dark:text-gray-400">Score last 7 days:</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $score_last_week ?? 0 }}%</dd>
                    </dl>
                </div>

                <div id="column-chart"></div>
                {{-- <div class="grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between pt-5">
                        <!-- Button -->
                        <button
                            class="inline-flex items-center text-center text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            id="dropdownDefaultButton"
                            data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            type="button">
                            Last 7 days
                            <svg class="m-2.5 ms-1.5 w-2.5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
                            id="lastDaysdropdown">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#">Yesterday</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#">Today</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#">Last 7 days</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#">Last 30 days</a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        href="#">Last 90 days</a>
                                </li>
                            </ul>
                        </div>
                        <a class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold uppercase text-blue-600 hover:bg-gray-100 hover:text-blue-700 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-blue-500 dark:focus:ring-gray-700"
                            href="#">
                            Leads Report
                            <svg class="ms-1.5 h-2.5 w-2.5 rtl:rotate-180"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>

        {{-- <div class="col-span-6">
            <div class="h-full rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
            </div>
        </div> --}}

        <div class="col-span-12 md:col-span-4">
            <div
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-2">
                <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                    <div>
                        <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total</h3>
                        <span
                            class="text-2xl font-bold leading-none text-gray-900 dark:text-white sm:text-3xl">Assignments</span>
                    </div>
                    {{-- <a class="inline-flex items-center rounded-lg p-2 text-xs font-medium uppercase text-blue-700 hover:bg-gray-100 dark:text-blue-500 dark:hover:bg-gray-700 sm:text-sm"
                        href="#">
                        Details
                        <svg class="ml-1 h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a> --}}
                </div>
                <!-- Donut Chart -->
                <div class="py-6"
                    id="donut-chart"
                    style="min-height: 378.7px;"></div>
                <!-- Card Footer -->
                <div class="flex items-center justify-evenly pt-4 sm:pt-6 lg:justify-evenly ">
                    <div>
                        <svg class="mb-1 h-8 w-8 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                        </svg>

                        <h3 class="text-gray-500 dark:text-gray-400">Unresolved</h3>
                        <h4 class="text-xl font-bold dark:text-white">
                            {{ $unresolved_assignments }}
                        </h4>
                    </div>
                    <div>
                        <svg class="mb-1 h-8 w-8 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                        </svg>

                        <h3 class="text-gray-500 dark:text-gray-400">Resolved</h3>
                        <h4 class="text-xl font-bold dark:text-white">
                            {{ $resolved_assignments }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="module">
        const options2 = {
            colors: ["#1A56DB", "#FDBA8C"],
            series: [{
                    name: "Assignment",
                    color: "#1A56DB",
                    data: {!! json_encode($assignment_last_week, JSON_PRETTY_PRINT) !!},
                },
            ],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadiusApplication: "end",
                    borderRadius: 8,
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            xaxis: {
                floating: false,
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
            },
            fill: {
                opacity: 1,
            },
        }

        if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("column-chart"), options2);
            chart.render();
        }

        const getChartOptions = () => {
            return {
                series: [{!! $resolved_assignments !!}, {!! $pending_assignments !!}, {!! $unresolved_assignments !!}],
                colors: ["#1C64F2", "#FDBA8C", "#E74694"],
                chart: {
                    height: 320,
                    width: "100%",
                    type: "donut",
                },
                stroke: {
                    colors: ["transparent"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    offsetY: 20,
                                },
                                total: {
                                    showAlways: true,
                                    show: true,
                                    label: "Total assignments",
                                    fontFamily: "Inter, sans-serif",
                                    formatter: function(w) {
                                        const sum = w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0)
                                        return sum
                                    },
                                },
                                value: {
                                    show: true,
                                    fontFamily: "Inter, sans-serif",
                                    offsetY: -20,
                                    formatter: function(value) {
                                        return value + "k"
                                    },
                                },
                            },
                            size: "80%",
                        },
                    },
                },
                grid: {
                    padding: {
                        top: -2,
                    },
                },
                labels: ["Resolved", "Pending", "Unresolved"],
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return value
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function(value) {
                            return value
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            }
        }

        if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
            chart.render();
        }
    </script>
@endsection
