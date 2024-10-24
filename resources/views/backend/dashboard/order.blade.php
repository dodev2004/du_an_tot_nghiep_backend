@extends('backend.index')

@section('style')
    @include('backend.components.head')
    @include('backend.components.chartCss')
    <style>
        .stat-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .stat-title {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 10px;
        }

        .stat-title span {
            font-size: 16px;
            font-weight: bold;
        }

        .stat-title button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .stat-title button:hover {
            background-color: #0056b3;
        }

        .stat-box h3 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .stat-box p {
            margin-bottom: 0;
            color: #888;
        }

        .chart-container {
            margin-bottom: 20px;
        }
        .stat-icon {
            font-size: 24px; /* Kích thước biểu tượng */
            margin-right: 2px; /* Khoảng cách giữa biểu tượng và tiêu đề */
        }

        .total-revenue {
            color: #27ae60; /* Màu xanh lá cho doanh thu */
        }

        .new-orders {
            color: #2980b9; /* Màu xanh dương cho đơn hàng mới */
        }

        .completed-orders {
            color: #8e44ad; /* Màu tím cho đơn hàng hoàn thành */
        }

        .canceled-orders {
            color: #c0392b; /* Màu đỏ cho đơn hàng bị hủy */
        }

    </style>
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <!-- Doanh thu -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="total-revenue"><i class="fas fa-dollar-sign"></i> Tổng Doanh Thu Cửa Hàng</span>
                </div>
                <h3>{{ number_format($totalRevenue, 0) }} VNĐ</h3>
                <p>Tổng doanh thu</p>
            </div>
        </div>
        <!-- Đơn hàng mới -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">

                    <span class="new-orders"><i class="fas fa-shopping-cart"></i> Đơn Hàng Mới</span>
                </div>
                <h3>{{ $totalNewOrders }}</h3>
                <p>Đơn hàng mới</p>
            </div>
        </div>
        <!-- Đơn hàng hoàn thành -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">

                    <span class="completed-orders"><i class="fas fa-check-circle"></i> Đơn Hàng Hoàn Thành</span>
                </div>
                <h3>{{ $totalCompletedOrders }}</h3>
                <p>Đơn hàng đã hoàn thành</p>
            </div>
        </div>

        <!-- Đơn hàng bị hủy -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="canceled-orders"><i class="fas fa-times-circle"></i> Đơn Hàng Bị Hủy</span>
                </div>
                <h3>{{ $totalCanceledOrders }}</h3>
                <p>Đơn hàng bị hủy</p>
            </div>
        </div>

    </div>

    {{-- <div class="row">

        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-title">
                    <span><i class="fas fa-money-bill-wave"></i> Tổng Tiền Chưa Thu</span>
                </div>
                <h3>{{ number_format($totalUnpaidAmount, 0) }} VNĐ</h3>
                <p>Tổng số tiền chưa thu từ đơn hàng hoàn thành</p>
            </div>
        </div>

    </div> --}}

    <div class="row">
        <!-- Biểu đồ Doanh thu theo tháng -->
        <div class="col-md-12 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"> </i> Doanh Thu Theo Tháng</h4>
                <canvas id="salesMonthlyChart"></canvas>
            </div>
        </div>



    </div>
    <div class="row">
        <!-- Biểu đồ Doanh thu theo năm -->
        <div class="col-md-12 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"> </i> Doanh Thu Theo Năm</h4>
                <canvas id="salesYearlyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="row">

        <!-- Biểu đồ Đơn hàng theo tháng -->
        <div class="col-md-6 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"></i> Số Lượng Đơn Hàng Theo Tháng</h4>
                <canvas id="ordersMonthlyChart"></canvas>
            </div>
        </div>

        <!-- Biểu đồ Đơn hàng theo năm -->
        <div class="col-md-6 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"></i> Số Lượng Đơn Hàng Theo Năm</h4>
                <canvas id="ordersYearlyChart"></canvas>
            </div>
        </div>

    </div>
    <div class="row">
        <!-- Biểu đồ Thanh toán theo tháng -->
        <div class="col-md-4 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"></i> Trạng Thái Thanh Toán Số Lượng Đơn Hàng Theo Tháng</h4>
                <canvas id="paymentsMonthlyChart"></canvas>
            </div>
        </div>

        <!-- Biểu đồ Đơn hàng bị hủy theo tháng -->
        <div class="col-md-4 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"></i> Số Lượng Đơn Hàng Bị Hủy Theo Tháng</h4>
                <canvas id="canceledOrdersMonthlyChart"></canvas>
            </div>
        </div>

        <!-- Biểu đồ Đơn hàng bị hủy theo năm -->
        <div class="col-md-4 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"></i> Số Lượng Đơn Hàng Bị Hủy Theo Năm</h4>
                <canvas id="canceledOrdersYearlyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-pie"> </i> Đơn Hàng Hoàn Thành và Bị Hủy Tháng Này</h4>
                <canvas id="orderStatusPieChart" ></canvas>
            </div>
        </div>
        <div class="col-md-6 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-pie"></i> Trạng Thái Thanh Toán Trong Tháng Này</h4>
                <canvas id="paymentStatusMonthlyChart"></canvas>
            </div>
        </div>
    </div>


    <!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        $(document).ready(function() {
            // Biểu đồ Doanh thu theo tháng (biểu đồ line)
            const salesMonthlyCtx = document.getElementById('salesMonthlyChart').getContext('2d');
            const salesMonthlyChart = new Chart(salesMonthlyCtx, {
                type: 'line',
                data: {
                    labels: @json($salesMonthly->pluck('month')),
                    datasets: [{
                        label: 'Doanh thu',
                        data: @json($salesMonthly->pluck('total')),
                        backgroundColor: 'rgba(52, 152, 219, 0.5)', // Xanh da trời nhạt
                        borderColor: 'rgba(52, 152, 219, 1)', // Xanh da trời đậm
                        borderWidth: 5,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,

                    scales: {

                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Doanh thu theo năm (biểu đồ đường)
            const salesYearlyCtx = document.getElementById('salesYearlyChart').getContext('2d');
            const salesYearlyChart = new Chart(salesYearlyCtx, {
                type: 'line', // Đảm bảo là kiểu đường
                data: {
                    labels: @json($salesYearly->pluck('year')),
                    datasets: [{
                        label: 'Doanh thu',
                        data: @json($salesYearly->pluck('total')),
                        backgroundColor: 'rgba(52, 152, 219, 0.5)', // Màu xanh da trời tươi sáng
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 5,
                        fill: true // Không tô màu bên dưới đường
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Đơn hàng theo tháng (biểu đồ cột)
            const ordersMonthlyCtx = document.getElementById('ordersMonthlyChart').getContext('2d');
            const ordersMonthlyChart = new Chart(ordersMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($ordersMonthly->pluck('month')),
                    datasets: [{
                            label: 'Đơn hàng hoàn thành',
                            data: @json($ordersMonthly->pluck('completed')),
                            backgroundColor: 'rgba(46, 204, 113, 0.7)', // Xanh lá cây tươi sáng
                            borderColor: 'rgba(46, 204, 113, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Đơn hàng bị hủy',
                            data: @json($ordersMonthly->pluck('canceled')),
                            backgroundColor: 'rgba(241, 196, 15, 0.7)', // Vàng sáng
                            borderColor: 'rgba(241, 196, 15, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true

                        }
                    }
                }
            });

            // Biểu đồ Đơn hàng theo năm (biểu đồ cột)
            const ordersYearlyCtx = document.getElementById('ordersYearlyChart').getContext('2d');
            const ordersYearlyChart = new Chart(ordersYearlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($ordersYearly->pluck('year')),
                    datasets: [{
                            label: 'Đơn hàng hoàn thành',
                            data: @json($ordersYearly->pluck('completed')),
                            backgroundColor: 'rgba(46, 204, 113, 0.7)', // Xanh lá cây tươi sáng
                            borderColor: 'rgba(46, 204, 113, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Đơn hàng bị hủy',
                            data: @json($ordersYearly->pluck('canceled')),
                            backgroundColor: 'rgba(241, 196, 15, 0.7)', // Vàng sáng
                            borderColor: 'rgba(241, 196, 15, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Thanh toán theo tháng (biểu đồ cột)
            const paymentsMonthlyCtx = document.getElementById('paymentsMonthlyChart').getContext('2d');
            const paymentsMonthlyChart = new Chart(paymentsMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($paymentsMonthly->pluck('month')),
                    datasets: [{
                            label: 'Đã thanh toán',
                            data: @json($paymentsMonthly->pluck('paid')),
                            backgroundColor: 'rgba(46, 204, 113, 0.7)', // Xanh lá cây tươi sáng
                            borderColor: 'rgba(52, 152, 219, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Chưa thanh toán',
                            data: @json($paymentsMonthly->pluck('unpaid')),
                            backgroundColor: 'rgba(231, 76, 60, 0.7)', // Đỏ tươi
                            borderColor: 'rgba(231, 76, 60, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Đơn hàng bị hủy theo tháng (biểu đồ cột)
            const canceledOrdersMonthlyCtx = document.getElementById('canceledOrdersMonthlyChart').getContext('2d');
            const canceledOrdersMonthlyChart = new Chart(canceledOrdersMonthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($canceledOrdersMonthly->pluck('month')),
                    datasets: [{
                        label: 'Đơn hàng bị hủy',
                        data: @json($canceledOrdersMonthly->pluck('total')),
                        backgroundColor: 'rgba(241, 196, 15, 0.7)', // Vàng sáng
                        borderColor: 'rgba(241, 196, 15, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Đơn hàng bị hủy theo năm (biểu đồ cột)
            const canceledOrdersYearlyCtx = document.getElementById('canceledOrdersYearlyChart').getContext('2d');
            const canceledOrdersYearlyChart = new Chart(canceledOrdersYearlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($canceledOrdersYearly->pluck('year')),
                    datasets: [{
                        label: 'Đơn hàng bị hủy',
                        data: @json($canceledOrdersYearly->pluck('total')),
                        backgroundColor: 'rgba(241, 196, 15, 0.7)', // Vàng sáng
                        borderColor: 'rgba(241, 196, 15, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // Biểu đồ Tỷ Lệ Đơn Hàng Hoàn Thành và Bị Hủy
            const orderStatusPieCtx = document.getElementById('orderStatusPieChart').getContext('2d');
            const orderStatusPieChart = new Chart(orderStatusPieCtx, {
                type: 'pie',
                data: {
                    labels: ['Đơn hàng hoàn thành', 'Đơn hàng bị hủy'],
                    datasets: [{
                        label: 'Tỷ lệ',
                        data: [{{ $totalCompletedThisMonth }}, {{ $totalCanceledThisMonth }}],
                        backgroundColor: [
                            'rgba(46, 204, 113, 0.7)', // Màu xanh lá cây
                            'rgba(241, 196, 15, 0.7)', // Màu vàng
                        ],
                        borderColor: [
                            'rgba(46, 204, 113, 1)',
                            'rgba(241, 196, 15, 1)',
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
                            text: 'Tỷ Lệ Đơn Hàng'
                        }
                    }
                }
            });
            // Biểu đồ Trạng Thái Thanh Toán Trong Tháng Này
            const paymentStatusMonthlyCtx = document.getElementById('paymentStatusMonthlyChart').getContext('2d');
            const paymentStatusMonthlyChart = new Chart(paymentStatusMonthlyCtx, {
                type: 'pie', // Sử dụng biểu đồ tròn
                data: {
                    labels: ['Đã Thanh Toán', 'Chưa Thanh Toán'],
                    datasets: [{
                        label: 'Trạng Thái Thanh Toán',
                        data: [
                            @json($paymentsThisMonth->paid),
                            @json($paymentsThisMonth->unpaid)
                        ],
                        backgroundColor: [
                            'rgba(46, 204, 113, 0.7)', // Xanh lá cây tươi sáng
                            'rgba(231, 76, 60, 0.7)' // Đỏ tươi
                        ],
                        borderColor: [
                            'rgba(46, 204, 113, 1)',
                            'rgba(231, 76, 60, 1)'
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
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem
                                        .raw; // Hiển thị số lượng trong tooltip
                                }
                            }
                        }
                    }
                }
            });


        });
    </script>
@endsection
