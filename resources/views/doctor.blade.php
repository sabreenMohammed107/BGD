@extends('layout.doctor.main')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="pt-4">Dashboard</h2>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <h4 class="p-3 pb-0">
                                Monthly Number of Reserved Patients
                                    <i class="fa fa-info text-primary p-2 float-end border border-primary rounded"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This statistical graph shows how many patients applied for a reservation during the last 5 month"></i>
                            </h4>
                            <canvas id="kt_chartjs_1" class="mh-400px"></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-6">
                        <div>
                            <h4 class="p-3 pb-0">This Month Clinics Reservations
                                <i class="fa fa-info text-primary p-2 float-end border border-primary rounded"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This statistical graph shows the reservations distribution all over the doctor clinics in this month"></i>

                            </h4>
                            {{-- <canvas id="kt_chartjs_4"></canvas> --}}
                        </div>


                    </div>
                    <div class="col-md-6">
                        <h4 class="p-3 pb-0">This Month Reservation
                            <i class="fa fa-info text-primary p-2 float-end border border-primary rounded"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="This statistical graph shows the reservations types percentages this month"></i>

                        </h4>
                        <canvas id="kt_chartjs_3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        var res_data = [];
        var labels = [];
        $.ajax({
            url: '/doctor/reservations/charts',
            method: 'GET',
            success: function(response) {
                console.log("Response:");
                console.log(response);
                labels = Object.keys(response[0]);
                res_data = Object.values(response[0]);

                pie_labels = Object.keys(response[1]);
                pie_data = Object.values(response[1]);

                pie_labels_2 = Object.keys(response[2]);
                pie_data_2 = Object.values(response[2]);

                var primaryColor = '#36a2eb';
                var dangerColor = '#ff6384';
                var successColor = '#4bc0c0';
                var warningColor = '#FF9800';
                var infoColor = '#2196F3';
                var fontFamily = 'Arial, sans-serif';

                const p_data = {
                    labels: pie_labels,
                    datasets: [{
                        label: 'Dataset',
                        data: pie_data,
                        backgroundColor: [primaryColor, dangerColor, successColor, warningColor,
                            infoColor
                        ],
                        borderWidth: 1
                    }]
                };

                const p_config = {
                    type: 'pie',
                    data: p_data,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: ''
                            }
                        },
                        responsive: true
                    },
                    defaults: {
                        global: {
                            defaultFont: fontFamily
                        }
                    }
                };
                var ctx = document.getElementById('kt_chartjs_3').getContext('2d');
                var myChart = new Chart(ctx, p_config);
                const p_data_2 = {
                    labels: pie_labels_2,
                    datasets: [{
                        label: 'Dataset',
                        data: pie_data_2,
                        backgroundColor: [primaryColor, dangerColor, successColor, warningColor,
                            infoColor
                        ],
                        borderWidth: 1
                    }]
                };

                const p_config_2 = {
                    type: 'pie',
                    data: p_data_2,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: ''
                            }
                        },
                        responsive: true
                    },
                    defaults: {
                        global: {
                            defaultFont: fontFamily
                        }
                    }
                };
                var ctx = document.getElementById('kt_chartjs_4').getContext('2d');
                var myChart = new Chart(ctx, p_config_2);

                // Chart data
                const data = {
                    labels: labels,
                    datasets: [{
                        label: '#Patients',
                        data: res_data,
                        backgroundColor: primaryColor, // Using the defined primaryColor variable for consistency
                    }]
                };

                // Chart config
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: '', // Title for the chart
                            }
                        },
                        responsive: true,
                        interaction: {
                            intersect: false,
                        },
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                            }
                        },
                        layout: {
                            padding: 20 // Adjust the padding as needed
                        },
                        defaults: {
                            global: {
                                defaultFont: fontFamily
                            }
                        }
                    }
                };

                // Get the chart canvas element by ID
                var ctx = document.getElementById('kt_chartjs_1');

                // Create the Chart instance
                var myChart = new Chart(ctx, config);
            },
            error: function(xhr, status, error) {
                console.error("Error:");
                console.error(xhr.responseText);
            }
        });
    </script>
@endsection
