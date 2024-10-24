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
            font-size: 24px;
            /* Kích thước biểu tượng */
            margin-right: 2px;
            /* Khoảng cách giữa biểu tượng và tiêu đề */
        }

        .total-revenue {
            color: #27ae60;
            /* Màu xanh lá cho doanh thu */
        }

        .new-orders {
            color: #2980b9;
            /* Màu xanh dương cho đơn hàng mới */
        }

        .completed-orders {
            color: #8e44ad;
            /* Màu tím cho đơn hàng hoàn thành */
        }

        .canceled-orders {
            color: #c0392b;
            /* Màu đỏ cho đơn hàng bị hủy */
        }

        .date-range-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .date-range-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            justify-content: center;
        }

        .date-range-item label {
            margin-right: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #2c3e50;
        }

        .date-range-item label i {
            color: #2980b9;
            margin-right: 5px;
        }

        input[type="date"] {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 200px;
        }

        button#filterBtn {
            background-color: #2980b9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button#filterBtn i {
            margin-right: 5px;
        }

        button#filterBtn:hover {
            background-color: #1a598d;
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

        <!-- Đơn hàng hoàn thành -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="completed-orders"><i class="fas fa-check-circle"></i> Đơn Hàng Đã Hoàn Thành</span>
                </div>
                <h3>{{ $totalCompletedOrders }}</h3>
                <p>Đơn hàng đã hoàn thành</p>
            </div>
        </div>

        <!-- Đơn hàng bị hủy -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="canceled-orders"><i class="fas fa-times-circle"></i> Đơn Hàng Đã Bị Hủy</span>
                </div>
                <h3>{{ $totalCanceledOrders }}</h3>
                <p>Đơn hàng đã bị hủy</p>
            </div>
        </div>
        <!-- Đơn hàng chưa thu tiền hôm nay -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="canceled-orders"><i class="fas fa-money-bill-wave"></i> Đơn Hàng Chưa Thu Tiền </span>
                </div>
                <h3>{{ $pendingPaymentOrdersToday }}</h3>
                <p>Đơn hàng chưa thu tiền hôm nay</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Doanh thu hôm nay -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="total-revenue"><i class="fas fa-dollar-sign"></i> Doanh Thu Hôm Nay</span>
                </div>
                <h3>{{ number_format($todayRevenue, 0) }} VNĐ</h3>
                <p>Doanh thu hôm nay</p>
            </div>
        </div>
        <!-- Đơn hàng hoàn thành hôm nay -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="total-revenue"><i class="fas fa-check-circle"></i> Đơn Hàng Hoàn Thành Hôm Nay</span>
                </div>
                <h3>{{ $completedOrdersToday }}</h3>
                <p>Đơn hàng hoàn thành hôm nay</p>
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

        <!-- Đơn hàng bị hủy hôm nay -->
        <div class="col-md-3">
            <div class="stat-box">
                <div class="stat-title">
                    <span class="canceled-orders"><i class="fas fa-times-circle"></i> Đơn Hàng Bị Hủy Hôm Nay</span>
                </div>
                <h3>{{ $canceledOrdersToday }}</h3>
                <p>Đơn hàng bị hủy hôm nay</p>
            </div>
        </div>
    </div>



    <div class="row">
        <!-- Biểu đồ Doanh thu theo tháng -->
        <div class="col-md-12 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"> </i> Biểu Đồ Doanh Thu Trong Năm</h4>
                <canvas id="salesMonthlyChart"></canvas>
            </div>
        </div>
        <div class="col-md-7 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"> </i> Biểu Đồ Số Lượng Đơn Hàng Trong Năm</h4>
                <canvas id="ordersMonthlyChart"></canvas>
            </div>
        </div>
        <div class="col-md-1 chart-container">

        </div>
        <div class="col-md-4 chart-container">
            <div class="stat-box">
                <h4><i class="fas fa-chart-line"> </i> Trạng Thái Đơn Hàng Trong Tháng</h4>
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>


    </div>




    <!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        $(document).ready(function() {
            var salesMonthly = @json($salesMonthly); // Nhận dữ liệu từ backend
            var labels = [];
            var data = [];

            // Khởi tạo mảng tháng và doanh thu
            for (var i = 1; i <= 12; i++) {
                labels.push('Tháng ' + i);
                var monthData = salesMonthly.find(item => item.month == i);
                data.push(monthData ? monthData.total : 0); // Nếu không có doanh thu thì mặc định là 0
            }

            // Vẽ biểu đồ đường
            var ctx = document.getElementById('salesMonthlyChart').getContext('2d');
            var salesMonthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh Thu (VNĐ)',
                        data: data,
                        backgroundColor: 'rgba(41, 128, 185, 0.2)', // Màu nền mờ xanh dương
                        borderColor: '#2980b9', // Màu xanh dương cho đường
                        borderWidth: 2,
                        fill: true, // Làm mờ dưới đường
                        tension: 0.4 // Làm cho đường cong mềm mại
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' VNĐ'; // Format VNĐ
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#2c3e50' // Màu chữ
                            }
                        }
                    }
                }
            });

            var completedOrders = @json($completedOrdersMonthly); // Dữ liệu đơn hàng hoàn thành theo tháng
            var canceledOrders = @json($canceledOrdersMonthly); // Dữ liệu đơn hàng bị hủy theo tháng
            var labels = [];
            var completedData = [];
            var canceledData = [];

            // Khởi tạo mảng tháng và số lượng đơn hàng
            for (var i = 1; i <= 12; i++) {
                labels.push('Tháng ' + i);
                var completedMonth = completedOrders.find(item => item.month == i);
                var canceledMonth = canceledOrders.find(item => item.month == i);
                completedData.push(completedMonth ? completedMonth.total : 0); // Đơn hàng hoàn thành
                canceledData.push(canceledMonth ? canceledMonth.total : 0); // Đơn hàng bị hủy
            }

            // Vẽ biểu đồ cột với hai bộ dữ liệu
            var ctx = document.getElementById('ordersMonthlyChart').getContext('2d');
            var ordersMonthlyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Đơn hàng hoàn thành',
                            data: completedData,
                            backgroundColor: '#27ae60', // Màu xanh lá cho đơn hàng hoàn thành
                            borderColor: '#2c3e50',
                            borderWidth: 1
                        },
                        {
                            label: 'Đơn hàng bị hủy',
                            data: canceledData,
                            backgroundColor: '#c0392b', // Màu đỏ cho đơn hàng bị hủy
                            borderColor: '#2c3e50',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString(); // Format số lượng đơn hàng
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#2c3e50' // Màu chữ
                            }
                        }
                    }
                }
            });
            var ctx = document.getElementById('orderStatusChart').getContext('2d');

            // Dữ liệu trạng thái đơn hàng
            const statusLabels = @json($statusLabels);
            const statusCounts = @json($statusCounts);

            // Tạo biểu đồ tròn
            const orderStatusChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Số Lượng Đơn Hàng',
                        data: statusCounts,
                        backgroundColor: [
                            'rgba(46, 204, 113, 0.6)', // Pending (Xanh lá)
                            'rgba(52, 152, 219, 0.6)', // Confirm (Xanh dương)
                            'rgba(241, 196, 15, 0.6)', // Processing (Vàng)
                            'rgba(231, 76, 60, 0.6)', // Shipped (Đỏ)
                            'rgba(39, 174, 96, 0.6)', // Completed (Xanh lá đậm)
                            'rgba(231, 76, 60, 0.6)', // Cancelled (Đỏ) - Mặc định là đỏ
                            'rgba(155, 89, 182, 0.6)', // Refunded (Tím)
                        ],
                        borderColor: [
                            'rgba(46, 204, 113, 1)', // Pending (Xanh lá)
                            'rgba(52, 152, 219, 1)', // Confirm (Xanh dương)
                            'rgba(241, 196, 15, 1)', // Processing (Vàng)
                            'rgba(231, 76, 60, 1)', // Shipped (Đỏ)
                            'rgba(39, 174, 96, 1)', // Completed (Xanh lá đậm)
                            'rgba(231, 76, 60, 1)', // Cancelled (Đỏ) - Mặc định là đỏ
                            'rgba(155, 89, 182, 1)', // Refunded (Tím)
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
                            text: 'Trạng Thái Đơn Hàng Trong Tháng'
                        }
                    }
                }
            });





        });
    </script>
@endsection
