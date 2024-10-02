@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link rel="stylesheet" href="{{ asset('backend/css/customize.css') }}">
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight" style="margin-top: -40px;">
        <div class="row">
            <div class="wrapper border-bottom white-bg page-heading" style="height: 90px; transform: translateX(-10px);">
                <div class="col">
                    <h2 style="line-height: 3;">{{ $title }}</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{ $title }}</h5><br />
                            <div class="ibox-content">
                                <div class="form_seach d-flex justify-content-between align-items-center">
                                    <form action="{{ route('admin.payment_methods') }}" method="GET"
                                        class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2" name="keywords"
                                            value="{{ request('keywords') }}" placeholder="Tìm kiếm theo tên"
                                            style="max-width: 250px;">
                                        <button type="submit" class="btn btn-primary me-2 seach">
                                            <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Thêm mới phương thức thanh toán
                                    </a>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tên phương thức thanh toán</th>
                                        <th>Mô tả phương thức thanh toán</th>
                                        <th class="text-center">Chỉnh sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentMethods as $item)
                                        <tr>
                                            <td><input type="checkbox" value="{{ $item->id }}"></td>
                                            <td>
                                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">
                                                    {{ $item->name }}
                                                </p>
                                            </td>
                                            <th>
                                                <p style="margin-bottom: 0;font-weight: 600;font-size: 14px;">
                                                    {{ $item->description }}</p>

                                                    <th class="text-center">
                                                        <a class="btn btn-sm btn-info" href="{{ route('admin.payment_methods.edit', $item->id) }}">
                                                            <i class="fa fa-paste"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.payment_methods.delete', $item->id) }}" method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger delete-button">
                                                                <i class="fa-solid fa-trash"></i> Xóa
                                                            </button>
                                                        </form>
                                                    </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('backend.components.scripts');
    @include('backend.payment_methods.handles.switchery');
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Xác nhận xóa với SweetAlert2
        document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Ngăn form không gửi ngay lập tức

                    Swal.fire({
                        title: 'Bạn có chắc chắn?',
                        text: "Bạn sẽ không thể khôi phục lại hành động này!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Vâng, xóa nó!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Nếu người dùng xác nhận, submit form
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });

        
    </script>
@endpush
