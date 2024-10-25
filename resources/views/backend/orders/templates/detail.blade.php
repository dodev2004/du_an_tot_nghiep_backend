@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link href="{{ asset('backend/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    @php

        if (!function_exists('getStatusOption')) {
            function getStatusOption($order)
            {
                $statusOptions = [];
                if ($order->status === 1) {
                    $statusOptions = [
                        2 => 'Xác nhận đơn hàng',
                        7 => 'Hủy đơn hàng',
                    ];
                } elseif ($order->status === 2) {
                    $statusOptions = [
                        3 => 'Xử lý đơn hàng',
                    ];
                } elseif ($order->status === 3) {
                    $statusOptions = [
                        4 => 'Xác nhận giao hàng',
                    ];
                } elseif ($order->status === 4) {
                    $statusOptions = [
                        5 => 'Đã giao hàng',
                    ];
                } elseif ($order->status === 5) {
                    $statusOptions = [
                        6 => 'Hoàn tất',
                    ];
                }
                return $statusOptions;
            }
        }
        if (!function_exists('getStatusColor')) {
            function getStatusColor($status)
            {
                switch ($status) {
                    case 1:
                        return '#FFC107'; // Đang chờ xử lý
                    case 2:
                        return '#28A745'; // Đã xác nhận
                    case 3:
                        return '#007BFF'; // Đang xử lý
                    case 4:
                        return '#17A2B8'; // Xác nhận giao hàng
                    case 5:
                        return '#28A745'; // Đã giao hàng
                    case 6:
                        return '#DC3545'; // Hủy đơn
                    default:
                        return '#000000'; // Mặc định
                }
            }
        }

        if (!function_exists('getOrderStatusLabel')) {
            function getOrderStatusLabel($status)
            {
                switch ($status) {
                    case 1:
                        return 'Chờ xử lý';
                    case 2:
                        return 'Đã xác nhận';
                    case 3:
                        return 'Đang xử lý';
                    case 4:
                        return 'Xác nhận giao hàng';
                    case 5:
                        return 'Đã giao hàng';
                    case 6:
                        return 'Hoàn tất';
                    case 7:
                        return 'Hủy';
                    default:
                        return 'Không xác định';
                }
            }
        }
        if (!function_exists('getOrderPaymentStatusLabel')) {
            function getOrderPaymentStatusLabel($status)
            {
                switch ($status) {
                    case 1:
                        return 'Chờ thanh toán';
                    case 2:
                        return 'Đã thanh toán';
                    case 3:
                        return 'Hoàn tiền';
                    default:
                        return 'Không xác định';
                }
            }
        }

    @endphp
    @include('backend.components.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h4>Chi tiết đơn hàng: BND{{ $orders->id }}</h4>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-left">Hình ảnh</th>
                                    <th style="width: 200px" class="text-left">Thông tin sản phẩm</th>
                                    <th class="text-right">Đơn giá</th>
                                    <th class="text-right">Số lượng</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($orders->orderItems  as $index => $item)

                                <tr>
                                    <td class="text-center">{{$index + 1}}</td>
                                    <td style="width:200px" class="text-left"><img src="{{$item->product->image_url}}" width="100" height="100" alt=""></td>
                                    <td style="width: 442px;" class="text-left">
                                        <b>Tên sản phẩm : </b> {{$item->product->name}}
                                        <br>
                                      <b>Lựa chọn : </b> {{implode("x",json_decode($item->variant, true))}}
                                    </td>
                                    <td class="text-right">{{number_format($item->price,0)}} đ</td>
                                    <td class="text-right">{{$item->quantity}}</td>
                                    <td class="text-right">{{number_format($item->total,0)}} đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Trạng thái đơn hàng</b> : {{getOrderStatusLabel($orders->status)}}
                                    <br>
                                    <b>Phương thức thanh toán</b> : {{$orders->paymentMethod->name}}
                                    <br>
                                    <b>Trạng thái thanh toán</b> : {{getOrderPaymentStatusLabel($orders->payment_status)}}
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin khách hàng</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        @include('backend.components.scripts');
        @include('backend.components.handles.switchery')
        @include('backend.components.toastmsg');
        <script src="{{ asset('backend/js/framework/delete2.js') }}"></script>
        @include('backend.components.handles.delete');
    @endpush