@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="md:grid md:grid-cols-12 md:gap-4">
        <div class="col-span-full md:order-1 md:col-span-8">
            <div
                class="border-1 relative space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="col-span-full md:order-2 md:col-span-4">
            <div class="border-1 relative rounded-lg border border-gray-200 p-4 dark:border-gray-700 dark:bg-gray-800">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        const ctx = document.getElementById('myChart');
        const pie = document.getElementById('pieChart');
        const data = {
            labels: [
                'Red',
                'Blue',
                'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 29, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const chart = new Chart(pie, {
            type: 'doughnut',
            data: data,
        });
    </script>
@endsection
