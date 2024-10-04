@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link rel="stylesheet" href="{{ asset('backend/css/customize.css') }}">
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    @include('backend.components.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>{{ $title }}</h5>
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
                        @include('backend.promotion.components.fillter')
                        @include('backend.promotion.components.table')
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('backend.components.scripts');
    @include('backend.posts.handle.switchery')
    @include('backend.components.toastmsg');
    <script src="{{ asset('backend/js/framework/delete2.js') }}"></script>

    @include('backend.promotion.handles.delete');


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
        // Kiểm tra nếu có session thành công
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Cập nhật thành công',
                text: 'Do you want to continue?',
                confirmButtonText: 'Tiếp tục',
                onClose: () => {
                    window.location.href =
                    "{{ route('admin.promotions') }}"; // Điều hướng về trang danh sách khuyến mãi
                }
            });
        @endif

        // Kiểm tra nếu có session lỗi
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Cập nhật thất bại',
                text: "{{ session('error') }}",
                confirmButtonText: 'Thử lại'
            });
        @endif
    </script> --}}
@endpush
