<!-- Radial Chart -->
<div class="max-h-40 max-w-sm overflow-clip" id="radial-chart"></div>

<script type="module">
    const getChartOptions = () => {
        return {
            series: [@json($assignments_radial['data'])],
            colors: ["#1C64F2"],
            chart: {
                height: "100%",
                width: "100%",
                type: "radialBar",
                offsetY: 0,
                sparkline: {
                    enabled: true,
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: '#E5E7EB',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: -2,
                            fontSize: "22px"
                        }
                    }
                },
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: 0,
                    bottom: 0,
                },
            },
            labels: ["Usage"],
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }

    if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions());
        chart.render();
    }
</script>
