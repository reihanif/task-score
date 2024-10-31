@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h6 class="text-xl font-semibold text-gray-800 dark:text-white">Dashboard</h6>

    <form x-data="{ submit() { $refs.form.submit() } }" x-ref="form" action="" method="GET">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-6 space-y-4">
                <div class="overflow-x-hidden h-full rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="inline-flex items-center space-x-4">
                        <img class="h-12 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&bold=true"
                            alt="{{ auth()->user()->name }} avatar" />

                        <div class="space-y-2">
                            <div class="text-sm font-semibold text-gray-700 dark:text-white">
                                Welcome, {{ auth()->user()->name }}
                            </div>
                            <a href="{{ route('auth.logout') }}"
                                class="inline-flex rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
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
            </div>

            <div class="col-span-12 md:col-span-6 space-y-4">
                <div class="overflow-x-hidden h-full rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center space-x-4">
                        <div class="flex-grow space-y-2">
                            <h1 class="text-2xl italic font-bold leading-none text-gray-900 dark:text-white sm:text-3xl">
                                SysAssignment
                            </h1>
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ config('app.version') }}</div>
                        </div>
                        <div class="inline-flex items-center">
                            <svg class="w-4.5 h-4.5 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11 4.717c-2.286-.58-4.16-.756-7.045-.71A1.99 1.99 0 0 0 2 6v11c0 1.133.934 2.022 2.044 2.007 2.759-.038 4.5.16 6.956.791V4.717Zm2 15.081c2.456-.631 4.198-.829 6.956-.791A2.013 2.013 0 0 0 22 16.999V6a1.99 1.99 0 0 0-1.955-1.993c-2.885-.046-4.76.13-7.045.71v15.081Z" clip-rule="evenodd"/>
                            </svg>
                            <a class="ms-2 hover:underline text-sm font-semibold text-gray-700 dark:text-white" href="{{ substr(config('app.asset_url'), 0, -1) . Storage::url('manual\User Manual - SysAssignment.pdf') }}"
                                download="User Manual - SysAssignment.pdf">
                                User Manual
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 md:col-span-4 lg:col-span-3 space-y-4">
                <div class="h-full gap-2 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div>
                        <label for="select-user" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Overview</label>
                        <select id="select-user" name="user" x-on:change="submit">
                            <option value="{{ $selected_user->id }}" selected>{{ $selected_user->name }}</option>
                            @if ($selected_user->id !== auth()->id())
                                <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                            @endif
                            @foreach (auth()->user()->subordinates as $user)
                                @if ($user->id !== $selected_user->id)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 border-b border-gray-200 pb-4 dark:border-gray-700">
                        <h6 class="block text-sm font-medium text-gray-900 dark:text-white">
                            Overall score :
                        </h6>
                        <div class="text-4xl font-bold text-blue-700 dark:text-blue-400">
                            {{ $overall_assignments['score'] ?? 0 }}%
                        </div>
                    </div>

                    <div class="mt-0">
                        <!-- Donut Chart -->
                        <div class="py-6"
                            id="donut-chart"
                            style="min-height: 378.7px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 md:col-span-8 lg:col-span-9">
                <!-- Bar Charts -->
                <div class="h-full rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 space-y-2 md:space-y-0 block md:flex md:justify-between border-b border-gray-200 pb-4 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="me-3 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 7V2.221a2 2 0 0 0-.5.365L3.586 6.5a2 2 0 0 0-.365.5H8Zm2 0V2h7a2 2 0 0 1 2 2v.126a5.087 5.087 0 0 0-4.74 1.368v.001l-6.642 6.642a3 3 0 0 0-.82 1.532l-.74 3.692a3 3 0 0 0 3.53 3.53l3.694-.738a3 3 0 0 0 1.532-.82L19 15.149V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M17.447 8.08a1.087 1.087 0 0 1 1.187.238l.002.001a1.088 1.088 0 0 1 0 1.539l-.377.377-1.54-1.542.373-.374.002-.001c.1-.102.22-.182.353-.237Zm-2.143 2.027-4.644 4.644-.385 1.924 1.925-.385 4.644-4.642-1.54-1.54Zm2.56-4.11a3.087 3.087 0 0 0-2.187.909l-6.645 6.645a1 1 0 0 0-.274.51l-.739 3.693a1 1 0 0 0 1.177 1.176l3.693-.738a1 1 0 0 0 .51-.274l6.65-6.646a3.088 3.088 0 0 0-2.185-5.275Z" clip-rule="evenodd"/>

                                </svg>

                            </div>
                            <div>
                                <h5 class="pb-1 text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ $range_assignments['total_assignment'] }}</h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $selected_user->name }} Assignment in {{ $selected_range }}</p>
                            </div>
                        </div>
                        <div class="text-end md:self-center">
                            <button data-dropdown-toggle="dropdown-range" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium text-sm rounded-lg px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                                <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                                    </svg>
                                {{ ucfirst($selected_range) }}
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdown-range" class="z-10 text-left hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                                    @foreach ($ranges as $range)
                                        <li>
                                            <div class="cursor-pointer flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input {{ $range == $selected_range ? 'checked' : '' }} x-on:click="submit" id="range-{{ str_replace(' ', '-', $range) }}" type="radio" value="{{ $range }}" name="range" class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="range-{{ str_replace(' ', '-', $range) }}" class="cursor-pointer w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ ucfirst($range) }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <dl class="flex items-center">
                            <dt class="me-1 text-sm font-normal text-gray-500 dark:text-gray-400">Resolved assignment :</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $range_assignments['total_resolved'] }}</dd>
                        </dl>
                        <dl class="flex items-center md:justify-end">
                            <dt class="me-1 text-sm font-normal text-gray-500 dark:text-gray-400">Score in {{ $selected_range }} :</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $range_assignments['score'] ?? 0 }}%</dd>
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
        </div>
    </form>

    @if (auth()->user()->subordinates->count() > 0)
        <div class="border-1 relative overflow-x-hidden rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-x-4 sm:space-y-0">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-white">My Subordinates</h5>
                </div>
                <div class="relative">
                    <div
                         class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400"></x-icons.search>
                    </div>
                    <input class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                           data-filter-target="my-subordinates"
                           data-filter-column="1"
                           data-filter-case-insensitive="true"
                           type="search"
                           placeholder="Search for subordinate">
                </div>
            </div>

            <div>
                <table class="datatables w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                    id="my-subordinates">
                    <thead class="hidden">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->subordinates->sortBy('name') as $assignee)
                            <tr class="border-b dark:border-gray-700 text-sm">
                                <th class="py-4 min-w-10 max-w-10 w-10" scope="col">
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($assignee->name) }}&background=0D8ABC&color=fff&bold=true"
                                        title="{{ $assignee->name }}"
                                        alt="{{ $assignee->name }} image">
                                </th>
                                <td class="whitespace-nowrap" scope="col">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white"
                                    title="{{ $assignee->name }}">
                                        {{ $assignee->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400"
                                    title="{{ $assignee->email }}">
                                        {{ $assignee->email }}
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-4 text-xs" scope="col">
                                    <span class="text-base font-semibold text-gray-900 dark:text-white">
                                        {{ $assignee->assignments->count() }}
                                    </span>
                                    Assignments
                                </td>
                                <td scope="col">
                                    <div class="float-end me-2 w-40 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $assignee->score <= 100 ? $assignee->score : '100' }}%"></div>
                                    </div>
                                </td>
                                <td class="font-semibold" scope="col">
                                    {{ $assignee->score }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection

@section('script')
<script type="module">
function formatDate(value) {
    let date = new Date(value);
    const dayOfWeek = new Intl.DateTimeFormat('en-US', { weekday: 'short' }).format(date);
    const day = new Intl.DateTimeFormat('en-US', { day: '2-digit' }).format(date);
    const month = new Intl.DateTimeFormat('en-US', { month: 'short' }).format(date);
    const year = new Intl.DateTimeFormat('en-US', { year: 'numeric' }).format(date);

    return { year, month, day, dayOfWeek };
}

const getBarChartOptions = (assignmentData) => {
    const fullDatePattern = /^\d{4}-\d{2}-\d{2}$/;
    const monthYearPattern = /^\d{4}-\d{2}$/;

    return {
        colors: ["#1A56DB", "#FDBA8C"],
        series: [
            {
                name: "Assignment",
                color: "#1A56DB",
                data: assignmentData,
            },
        ],
        chart: {
            type: "bar",
            height: "320px",
            fontFamily: "Inter, sans-serif",
            toolbar: { show: false },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 4,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: { fontFamily: "Inter, sans-serif" },
            x: {
                show: true,
                formatter: function (value) {
                    const { year, month, day, dayOfWeek } = formatDate(value);
                    return fullDatePattern.test(value) ? `${dayOfWeek}, ${day} ${month} ${year}` : `${month} ${year}`;
                },
            },
        },
        states: {
            hover: { filter: { type: "darken", value: 1 } },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: { left: 2, right: 2, top: -14 },
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            floating: false,
            labels: {
                show: true,
                style: { fontFamily: "Inter, sans-serif", cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400' },
                formatter: function (value) {
                    const { year, month, day, dayOfWeek } = formatDate(value);

                    if (fullDatePattern.test(value)) {
                        return assignmentData.length > 7 ? `${day}` : `${dayOfWeek}, ${day} ${month}`;
                    } else if (monthYearPattern.test(value)) {
                        return `${month} ${year}`
                    }
                },
            },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: { show: false },
        fill: { opacity: 1 },
    }
};

const getDonutChartOptions = (resolved, pending, unresolved) => ({
    series: [resolved, pending, unresolved],
    colors: ["#1C64F2", "#FDBA8C", "#E74694"],
    chart: { height: 320, width: "100%", type: "donut" },
    stroke: { colors: ["transparent"], lineCap: "" },
    plotOptions: {
        pie: {
            donut: {
                labels: {
                    show: true,
                    name: { show: true, fontFamily: "Inter, sans-serif", offsetY: 20 },
                    total: {
                        showAlways: true,
                        show: true,
                        label: "Assignments",
                        fontFamily: "Inter, sans-serif",
                        formatter: function(w) {
                            const sum = w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0)
                            return sum
                        },
                    },
                    value: {
                        show: true,
                        fontFamily: "Inter, sans-serif",
                        offsetY: -20,
                        formatter: function(value) {
                            return value
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
});

if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const assignmentData = @json($range_assignments['assignments']);
    const barChart = new ApexCharts(document.getElementById("column-chart"), getBarChartOptions(assignmentData));
    barChart.render();
}

if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
    const resolved = @json($overall_assignments['resolved']);
    const pending = @json($overall_assignments['pending']);
    const unresolved = @json($overall_assignments['unresolved']);
    const donutChart = new ApexCharts(document.getElementById("donut-chart"), getDonutChartOptions(resolved, pending, unresolved));
    donutChart.render();
}
</script>
@endsection
