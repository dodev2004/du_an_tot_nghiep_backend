@extends('backend.index')

@section('style')
    @include('backend.components.head')
    @include('backend.components.chartCss')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <!-- Tổng doanh thu toàn bộ -->
        <div class="col-md-6">
            <canvas id="monthlySalesChart"></canvas>
        </div>

        <!-- Biểu đồ doanh thu theo năm -->
        <div class="col-md-6">
            <canvas id="yearlySalesChart"></canvas>
        </div>

        <!-- Biểu đồ cột: số lượng đơn hàng hoàn thành theo tháng -->
        <div class="col-md-6">
            <canvas id="completedOrdersMonthlyChart"></canvas>
        </div>

        <!-- Biểu đồ cột: số lượng đơn hàng hoàn thành theo năm -->
        <div class="col-md-6">
            <canvas id="completedOrdersYearlyChart"></canvas>
        </div>


        <!-- Biểu đồ cột: số lượng đơn hàng bị huỷ theo tháng -->
        <div class="col-md-6">
            <canvas id="cancelledOrdersMonthlyChart"></canvas>
        </div>

        <!-- Biểu đồ cột: số lượng đơn hàng bị huỷ theo năm -->
        <div class="col-md-6">
            <canvas id="cancelledOrdersYearlyChart"></canvas>
        </div>
        <!-- Biểu đồ tròn: trạng thái đơn hàng -->
        <div class="col-md-6">
            <canvas id="orderStatusChart"></canvas>
        </div>

        <!-- Hiển thị số lượng đơn hàng hoàn thành trong tháng và năm -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Stats</h3>
                </div>
                <div class="panel-body">
                    <p><strong>Completed Orders This Month:</strong> {{ $completedOrdersMonthly }}</p>
                    <p><strong>Completed Orders This Year:</strong> {{ $completedOrdersYearly }}</p>
                    <p><strong>Unpaid Completed Orders:</strong> {{ $unpaidOrders }}</p>
                    <p><strong>Total Amount of Unpaid Orders:</strong> ${{ number_format($totalUnpaidOrdersAmount, 2) }}</p>
                    <div class="row text-left">
                        <div class="col-xs-4">
                            <div class="m-l-md">
                                <span class="h4 font-bold m-t block">${{ number_format($totalSales, 2) }}</span>
                                <small class="text-muted m-b block">Total Sales (All Time)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Dữ liệu cho biểu đồ doanh thu theo tháng
            var monthlyLabels = {!! json_encode($monthlyLabels) !!}; // Nhãn cho các tháng
            var monthlyData = {!! json_encode($monthlyData) !!}; // Dữ liệu doanh thu theo tháng

            // Dữ liệu cho biểu đồ doanh thu theo năm
            var yearlyLabels = {!! json_encode($yearlyLabels) !!}; // Nhãn cho các năm
            var yearlyData = {!! json_encode($yearlyData) !!}; // Dữ liệu doanh thu theo năm

            // Dữ liệu cho số lượng đơn hàng hoàn thành theo tháng
            var completedOrdersMonthlyData = {!! json_encode($monthlyCompletedOrders) !!}; // Dữ liệu đơn hàng hoàn thành theo tháng

            // Dữ liệu cho số lượng đơn hàng hoàn thành theo năm
            var completedOrdersYearlyData = {!! json_encode($yearlyCompletedOrders) !!}; // Dữ liệu đơn hàng hoàn thành theo năm

            // Dữ liệu cho số lượng đơn hàng bị huỷ theo tháng
            var cancelledOrdersMonthlyLabels = {!! json_encode($cancelledOrdersMonthly->pluck('month')) !!};
            var cancelledOrdersMonthlyData = {!! json_encode($cancelledOrdersMonthly->pluck('cancelled_count')) !!};

            // Dữ liệu cho số lượng đơn hàng bị huỷ theo năm
            var cancelledOrdersYearlyLabels = {!! json_encode($cancelledOrdersYearly->pluck('year')) !!};
            var cancelledOrdersYearlyData = {!! json_encode($cancelledOrdersYearly->pluck('cancelled_count')) !!};

            // Dữ liệu cho biểu đồ tròn
            var orderStatusLabels = {!! json_encode($orderStatusLabels) !!};
            var orderStatusData = {!! json_encode($orderStatusData) !!};

            // Vẽ biểu đồ cột doanh thu theo tháng bằng Chart.js
            var monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
            var monthlySalesChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Monthly Sales ($)',
                        data: monthlyData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10000 // Đặt khoảng cách giữa các vạch là 10000
                            }
                        }
                    }
                }
            });

            // Vẽ biểu đồ cột doanh thu theo năm bằng Chart.js
            var yearlyCtx = document.getElementById('yearlySalesChart').getContext('2d');
            var yearlySalesChart = new Chart(yearlyCtx, {
                type: 'bar',
                data: {
                    labels: yearlyLabels,
                    datasets: [{
                        label: 'Yearly Sales ($)',
                        data: yearlyData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10000 // Đặt bước tăng của vạch y-axis cho sự nhất quán
                            }

                        }
                    }
                }
            });

            // Vẽ biểu đồ cột số lượng đơn hàng hoàn thành theo tháng
            var completedOrdersMonthlyCtx = document.getElementById('completedOrdersMonthlyChart').getContext('2d');
            var completedOrdersMonthlyChart = new Chart(completedOrdersMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: monthlyLabels, // Nhãn tháng
                    datasets: [{
                        label: 'Completed Orders This Month',
                        data: completedOrdersMonthlyData, // Số lượng đơn hàng đã hoàn thành theo tháng
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10 // Hoặc bất kỳ giá trị nào phù hợp với dữ liệu của bạn
                            }
                        }
                    }
                }
            });

            // Vẽ biểu đồ cột số lượng đơn hàng hoàn thành theo năm
            var completedOrdersYearlyCtx = document.getElementById('completedOrdersYearlyChart').getContext('2d');
            var completedOrdersYearlyChart = new Chart(completedOrdersYearlyCtx, {
                type: 'bar',
                data: {
                    labels: yearlyLabels, // Nhãn năm
                    datasets: [{
                        label: 'Completed Orders This Year',
                        data: completedOrdersYearlyData, // Số lượng đơn hàng đã hoàn thành theo năm
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10 // Hoặc bất kỳ giá trị nào phù hợp với dữ liệu của bạn
                            }
                        }
                    }
                }
            });

            // Vẽ biểu đồ tròn cho trạng thái đơn hàng
            var orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
            var orderStatusChart = new Chart(orderStatusCtx, {
                type: 'pie',
                data: {
                    labels: orderStatusLabels,
                    datasets: [{
                        label: 'Order Status',
                        data: orderStatusData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Order Status Distribution'
                        }
                    }
                }
            });

            // Vẽ biểu đồ cột số lượng đơn hàng bị huỷ theo tháng
            var cancelledOrdersMonthlyCtx = document.getElementById('cancelledOrdersMonthlyChart').getContext('2d');
            var cancelledOrdersMonthlyChart = new Chart(cancelledOrdersMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: cancelledOrdersMonthlyLabels,
                    datasets: [{
                        label: 'Cancelled Orders This Month',
                        data: cancelledOrdersMonthlyData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });



            // Vẽ biểu đồ cột số lượng đơn hàng bị huỷ theo năm
            var cancelledOrdersYearlyCtx = document.getElementById('cancelledOrdersYearlyChart').getContext('2d');
            var cancelledOrdersYearlyChart = new Chart(cancelledOrdersYearlyCtx, {
                type: 'bar',
                data: {
                    labels: cancelledOrdersYearlyLabels,
                    datasets: [{
                        label: 'Cancelled Orders This Year',
                        data: cancelledOrdersYearlyData,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        });
        // Dữ liệu cho số lượng đơn hàng bị huỷ theo tháng
    </script>
@endsection

@push('scripts')
    @include('backend.components.scripts')
    @include('backend.components.chartJs')
@endpush
