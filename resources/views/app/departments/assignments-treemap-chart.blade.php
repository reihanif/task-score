<!-- Treemap Chart -->
<div class="h-64">
    <div id="treemap-chart"></div>
</div>

<script type="module">
    const getChartOptions = () => {
        return {
            series: [{
                data: @json($assignments_treemap),
            }],
            chart: {
                height: "100%",
                width: "100%",
                type: "treemap",
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                y: {
                formatter: function(value) {
                    return value + ' assignments';
                }
                }
            },
            noData: {
                text: 'No Data Available',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    fontSize: '0.75rem',
                    fontFamily: 'ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"'
                }
            },
            grid: {
                padding: {
                    top: -20,
                    right: -25
                }
            },
            plotOptions: {
                treemap: {
                    distributed: true,
                    enableShades: false,
                    useFillColorAsStroke: true,
                    dataLabels: {
                        format: "truncate",
                    },
                },
            },
            dataLabels: {
                style: {
                    fontWeight: "400",
                },
            },
        }
    }

    if (document.getElementById("treemap-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.querySelector("#treemap-chart"), getChartOptions());
        chart.render();
    }
</script>
