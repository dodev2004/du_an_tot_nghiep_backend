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

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection


@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <!-- Doanh thu -->
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="stat-box">
                    <div class="stat-title">
                        <span class="total-revenue"><i class="fas fa-dollar-sign"></i> Tổng Doanh Thu Cửa Hàng</span>
                    </div>
                    <h3>{{ number_format($totalRevenue, 0) }} VNĐ</h3>
                    <p>Tổng doanh thu</p>
                </div>
            </div>
            <!-- Doanh thu hôm nay -->
            <div class="col-md-6">
                <div class="stat-box">
                    <div class="stat-title">
                        <span class="total-revenue"><i class="fas fa-dollar-sign"></i> Doanh Thu Hôm Nay</span>
                    </div>
                    <h3>{{ number_format($todayRevenue, 0) }} VNĐ</h3>
                    <p>Doanh thu hôm nay</p>
                </div>
            </div>
            <!-- Đơn hàng hoàn thành hôm nay -->
            <div class="col-md-6">
                <div class="stat-box">
                    <div class="stat-title">
                        <span class="total-revenue"><i class="fas fa-check-circle"></i> Đơn Hàng Hoàn Thành Hôm Nay</span>
                    </div>
                    <h3>{{ $completedOrdersToday }}</h3>
                    <p>Đơn hàng hoàn thành hôm nay</p>
                </div>
            </div>
            <!-- Đơn hàng mới -->
            <div class="col-md-6">
                <div class="stat-box">
                    <div class="stat-title">
                        <span class="new-orders"><i class="fas fa-shopping-cart"></i> Đơn Hàng Mới</span>
                    </div>
                    <h3>{{ $totalNewOrders }}</h3>
                    <p>Đơn hàng mới</p>
                </div>
            </div>

            <!-- Đơn hàng bị hủy hôm nay -->
            <div class="col-md-6">
                <div class="stat-box">
                    <div class="stat-title">
                        <span class="canceled-orders"><i class="fas fa-times-circle"></i> Đơn Hàng Bị Hủy Hôm Nay</span>
                    </div>
                    <h3>{{ $canceledOrdersToday }}</h3>
                    <p>Đơn hàng bị hủy hôm nay</p>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            {{-- <!-- Đơn hàng hoàn thành -->
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
            </div> --}}
            <div class="stat-box">
                <div class="stat-title">
                    <span class="canceled-orders"><i class="fas fa-box"></i> Trạng thái đơn hàng </span>
                </div>
                <div id="orderStatusChart" style="height: 369px;"></div>
            </div>
        </div>

        <div class="row">

        </div>



        <div class="row">

            <div class="col-md-8">
                <form id="filterForm">

                    @csrf
                    <!-- Form lọc theo ngày -->

                    <div class="filter-box col-md-3" style="width: 250px;margin-left: 11px">


                        <div class="form-group">
                            <label for="fromDate">Từ ngày:</label>
                            <input type="text" class="form-control datepicker" id="fromDate" name="fromDate"
                                placeholder="Chọn ngày bắt đầu" readonly>
                        </div>
                    </div>
                    <div class="col-md-3" style="width: 250px">
                        <div class="form-group">
                            <label for="toDate">Đến ngày:</label>
                            <input type="text" class="form-control datepicker" id="toDate" name="toDate"
                                placeholder="Chọn ngày kết thúc" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id='filter' style="margin-top:23px">Lọc</button>

                </form>
            </div>
            <div class="col-md-2">
                <label for="">Lọc doanh thu theo</label>
                <select class="dashboard-filter form-control">
                    <option value="7ngay">7 ngày qua</option>
                    <option value="thangnay" selected>tháng này</option>
                    <option value="thangtruoc">tháng trước</option>
                    <option value="365ngayqua">365 ngày qua</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:50px">
            <!-- Biểu đồ Doanh thu theo tháng -->
            <div class="col-md-12 chart-container">
                <div class="stat-box">
                    <h4><i class="fas fa-chart-line"> </i> Biểu Đồ Doanh Thu</h4>
                    <div id="salesMonthlyChart" style="height: 500px;"></div>
                </div>
            </div>

        </div>




        <!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                var chartData = @json($chartData); // Lấy dữ liệu từ controller

                var chart = new Morris.Line({
                    element: 'salesMonthlyChart',
                    data: chartData, // Dữ liệu từ server
                    xkey: 'created_at',
                    ykeys: ['final_amount'],
                    labels: ['Doanh thu'],

                    // Tùy chỉnh giao diện
                    lineColors: ['#0b62a4'], // Màu đường
                    lineWidth: 2, // Độ rộng đường
                    pointSize: 4, // Kích thước điểm
                    pointFillColors: ['#ffffff'], // Màu điểm
                    pointStrokeColors: ['#0b62a4'], // Màu viền điểm
                    gridTextColor: '#333', // Màu chữ lưới
                    gridTextSize: 12, // Kích thước chữ lưới
                    hideHover: 'auto', // Tự động ẩn tooltip khi không hover

                    // Tùy chỉnh hiển thị trục Y
                    yLabelFormat: function(y) {
                        return y.toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    },

                    // Tùy chỉnh trục X
                    xLabelAngle: 0, // Xoay trục X để dễ đọc
                    resize: true, // Tự động điều chỉnh kích thước khi cửa sổ thay đổi

                    // Thêm tooltip format
                    hoverCallback: function(index, options, content, row) {
                        return `<div style="padding: 8px;"><strong>Ngày:</strong> ${row.created_at}<br><strong>Doanh thu:</strong> ${row.final_amount.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'})}</div>`;
                    }
                });


                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date(),
                    clearBtn: true,
                    todayBtn: "linked",
                    language: "vi",
                });
                // Thiết lập Datepicker cho từ ngày
                $('#fromDate').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date(),
                    clearBtn: true,
                    todayBtn: "linked",
                    language: "vi"
                }).on('changeDate', function(e) {
                    // Khi người dùng chọn từ ngày, thiết lập ngày bắt đầu cho đến ngày
                    $('#toDate').datepicker('setStartDate', e.date);
                });

                // Thiết lập Datepicker cho đến ngày
                $('#toDate').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date(),
                    clearBtn: true,
                    todayBtn: "linked",
                    language: "vi"
                }).on('changeDate', function(e) {
                    // Khi người dùng chọn đến ngày, thiết lập ngày kết thúc cho từ ngày
                    $('#fromDate').datepicker('setEndDate', e.date);
                });
                let previousValue = $('.dashboard-filter').val();

                $('.dashboard-filter').on('change', function(event) {
                    event.preventDefault();

                    var dashboard_value = $(this).val();
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    // Xóa dữ liệu trong form khi chọn select
                    $('#filterForm')[0].reset();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('orders.select') }}',
                        dataType: "json",
                        data: {
                            dashboard_value: dashboard_value,
                            _token: _token
                        },
                        headers: {
                            "X-HTTP-Method-Override": "GET"
                        },
                        success: function(response) {


                            chart.setData(response);
                            previousValue = dashboard_value;

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Không có doanh thu',
                                text: 'Không có doanh thu cho khoảng thời gian này.',
                                confirmButtonText: 'Đóng',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                            // Đặt lại select khi submit form
                            $('.dashboard-filter').val(previousValue);
                            console.error(xhr.responseText);
                        }
                    });
                });

                $('#filterForm').on('submit', function(event) {
                    event.preventDefault();




                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
                    if (new Date(fromDate) > new Date(toDate)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Ngày kết thúc không thể nhỏ hơn ngày bắt đầu.',
                        });
                        return; // Ngừng thực hiện nếu không hợp lệ
                    }
                    // Kiểm tra xem người dùng đã chọn đủ ngày chưa
                    if (!fromDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Vui lòng chọn ngày bắt đầu.',
                        });
                        return; // Ngừng thực hiện nếu không đủ dữ liệu
                    }

                    if (!toDate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Vui lòng chọn ngày kết thúc.',
                        });
                        return; // Ngừng thực hiện nếu không đủ dữ liệu
                    }
                    // Đặt lại select khi submit form
                    $('.dashboard-filter').val('');
                    $.ajax({
                        type: "POST",
                        url: '{{ route('orders.filter') }}',
                        dataType: "json",
                        data: {
                            fromDate: fromDate,
                            toDate: toDate,
                            _token: _token
                        },
                        headers: {
                            "X-HTTP-Method-Override": "GET"
                        },
                        success: function(response) {


                            chart.setData(response);
                            console.log(chart);

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Không có doanh thu',
                                text: 'Không có doanh thu cho khoảng thời gian này.',
                                confirmButtonText: 'Đóng',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                            // Xóa dữ liệu trong form khi chọn select
                            $('#filterForm')[0].reset();
                            console.error(xhr.responseText);
                        }
                    });
                });
                const orderStatusData = @json($orderStatusData);

                Morris.Donut({
                    element: 'orderStatusChart',
                    data: orderStatusData,
                    colors: ["#ffcc00", "#3366ff", "#33cc33", "#4caf50", "#ff4444", "#ff6384"],
                    resize: true,
                    formatter: function(value, data) {
                        return value + " đơn hàng";
                    }
                });
            });
        </script>
    @endsection
