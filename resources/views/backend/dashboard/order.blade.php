@extends('backend.index')
@section("style")
@include('backend.components.head')
@include('backend.components.chartCss')
@endsection
@section("title")
{{$title}}
@endsection
@section("content")
<div class="col-md-6">

            <canvas id="monthlySalesChart"></canvas>

    <div class="row text-left">
        <!-- Tổng doanh thu toàn bộ -->
        <div class="col-xs-4">
            <div class=" m-l-md">
                <span class="h4 font-bold m-t block">${{ number_format($totalSales, 2) }}</span>
                <small class="text-muted m-b block">Total Sales (All Time)</small>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">

            <canvas id="yearlySalesChart"></canvas>
        
</div>

<!-- Thêm Chart.js và jQuery để vẽ biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Dữ liệu cho biểu đồ doanh thu theo tháng
        var monthlyLabels = {!! json_encode($monthlyLabels) !!}; // Nhãn cho các tháng
        var monthlyData = {!! json_encode($monthlyData) !!};     // Dữ liệu doanh thu theo tháng
        // Dữ liệu cho biểu đồ doanh thu theo năm
        var yearlyLabels = {!! json_encode($yearlyLabels) !!}; // Nhãn cho các năm
        var yearlyData = {!! json_encode($yearlyData) !!};     // Dữ liệu doanh thu theo năm

        // Vẽ biểu đồ cột doanh thu theo tháng bằng Chart.js
        var monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
        var monthlySalesChart = new Chart(monthlyCtx, {
            type: 'bar', // Biểu đồ cột
            data: {
                labels: monthlyLabels, // Nhãn tháng-năm
                datasets: [{
                    label: 'Monthly Sales ($)',
                    data: monthlyData, // Dữ liệu doanh thu theo tháng
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        // Vẽ biểu đồ cột doanh thu theo năm bằng Chart.js
        var yearlyCtx = document.getElementById('yearlySalesChart').getContext('2d');
        var yearlySalesChart = new Chart(yearlyCtx, {
            type: 'bar', // Biểu đồ cột
            data: {
                labels: yearlyLabels, // Nhãn năm
                datasets: [{
                    label: 'Yearly Sales ($)',
                    data: yearlyData, // Dữ liệu doanh thu theo năm
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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
    });
</script>
@endsection
@push('scripts')
    @include('backend.components.scripts')
    @include("backend.components.chartJs")
@endpush
