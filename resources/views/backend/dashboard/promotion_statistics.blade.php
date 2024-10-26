@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link rel="stylesheet" href="{{ asset('backend/css/customize.css') }}">
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .statistics-container {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }

        .stat-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 22%;
            text-align: center;
        }

        .stat-box h2 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #333;
        }

        .stat-box p {
            margin-bottom: 0;
            color: #888;
        }

        .stat-box .status {
            margin-top: 10px;
            font-size: 12px;
            font-weight: bold;
            color: green;
        }

        .stat-box .low-value {
            color: red;
        }

        .stat-box .medium-value {
            color: orange;
        }

        .charts-container {
            display: flex;
            justify-content: space-around;
            margin: 50px;
            flex-wrap: wrap;
        }
        .total-revenue {
            color: #27ae60;
            font-weight: bold;
            
        }
        .inactive{
            color: red
        }
        .total {
            color: #0a4aeb;
        }
        .chart-container {
            width: 45%;
            text-align: center;
            margin-bottom: 20px;
        }

        #promotionChart,
        #topCouponsChart {
            width: 100% !important;
            height: 300px !important;
        }
    </style>
    </head>

    <body>
        
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="statistics-container">
                <div class="stat-box">
                    <span class="total"><h3>Tổng số lượng mã giảm giá</h3></span>
                    <h2>{{ $totalCouponsInMonth }}</h2>
                    <p>Mã giảm giá</p>
                    <div class="status medium-value"></div>
                </div>
                <div class="stat-box">
                    <span class="total-revenue"><h3>Mã giảm giá hoạt động</h3></span>
                    <h2>{{ $activeCoupons }}</h2>
                    <div class="status">Hoạt động</div>
                </div>
                <div class="stat-box">
                    <span class="inactive"><h3>Mã giảm giá không hoạt động</h3></span>
                    <h2>{{ $inactiveCoupons }}</h2>
                    <div class="status low-value">Không hoạt động</div>
                </div>
            </div>

            <div class="charts-container">
                <!-- Biểu đồ tổng quan -->
                <div class="chart-container">
                    <canvas id="promotionChart"></canvas>
                </div>

                <!-- Biểu đồ mã giảm giá được sử dụng nhiều nhất -->
                <div class="chart-container">
                    <canvas id="topCouponsChart"></canvas>
                </div>
            </div>
        </div>
        <script>
            // Dữ liệu truyền từ Laravel
            const totalCouponsInMonth = {{ $totalCouponsInMonth }};
            const activeCoupons = {{ $activeCoupons }};
            const inactiveCoupons = {{ $inactiveCoupons }};

            const ctx1 = document.getElementById('promotionChart').getContext('2d');
            const promotionChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Hoạt động', 'Không hoạt động'],
                    datasets: [{
                        label: 'Tổng số',
                        data: [activeCoupons, inactiveCoupons],
                        backgroundColor: ['#36a2eb', '#ff6384'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Hoạt động và không hoạt động'
                        }
                    }
                }
            });

            // Dữ liệu mã giảm giá được sử dụng nhiều nhất
            const topCoupons = @json($topCoupons);
            const couponCodes = topCoupons.map(coupon => coupon.code);
            const usageCounts = topCoupons.map(coupon => coupon.used_count);

            const ctx2 = document.getElementById('topCouponsChart').getContext('2d');
            const topCouponsChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: couponCodes,
                    datasets: [{
                        label: 'Số lần sử dụng',
                        data: usageCounts,
                        backgroundColor: '#36a2eb',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                        },
                        title: {
                            display: true,
                            text: 'Mã Giảm Giá Được Sử Dụng Nhiều Nhất'
                        }
                    }
                }
            });
        </script>
    </body>
@endsection
