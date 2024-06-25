@extends('backend/template/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li> --}}
                            {{-- <li class="breadcrumb-item"><a href="#">Layout</a></li> --}}
                            {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Dounat Chart</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bar Chart</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

    </div>
    <script src="{{ asset('backend/js/Chart.min.js') }}"></script>
    <script>
        function generateColors(count) {
            // Define an array of base colors
            const baseColors = ['#f56954', '#00a65a', '#f39c12', '#007bff', '#6610f2', '#17a2b8', '#28a745', '#dc3545',
                '#ffc107', '#6c757d'
            ];

            // Initialize an array to store generated colors
            let colors = [];

            // Generate colors based on the count of data points
            for (let i = 0; i < count; i++) {
                // Use modulus operator to cycle through base colors if count exceeds the number of base colors
                colors.push(baseColors[i % baseColors.length]);
            }

            return colors;
        }

        var pieData = {
            labels: {!! json_encode($kategoriLabels) !!},
            datasets: [{
                data: {!! json_encode($kategoriCountsData) !!},
                backgroundColor: generateColors({{ count($kategoriLabels) }}),
            }]
        };

        var barData = {
            labels: {!! json_encode($kategoriLabels) !!},
            datasets: [{
                label: '',
                data: {!! json_encode($kategoriCountsData) !!},
                backgroundColor: generateColors({{ count($kategoriLabels) }}),
                borderColor: generateColors({{ count($kategoriLabels) }}),
                borderWidth: 1
            }]
        };

        // pie chart
        var pieChartCanvas = $('#donutChart').get(0).getContext('2d')
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            title: {
                display: true,
                text: 'Data per kategori'
            }
        }
        new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieData,
            options: pieOptions
        })

        // bar chart
        var barChartCanvas = $('#barChart').get(0).getContext('2d')

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            title: {
                display: true,
                text: 'Data per kategori'
            }
        }

        new Chart(barChartCanvas, {
            type: 'horizontalBar',
            data: barData,
            options: barChartOptions
        })
    </script>
@endsection
