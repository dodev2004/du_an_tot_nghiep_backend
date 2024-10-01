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
                                <div class="form_seach">
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
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('admin.payment_methods.edit', $item->id) }}"><i
                                                        class="fa fa-paste"></i> Edit</a>
                                                <form action="" method="POST" data-url="payment_methods"
                                                    class="form-delete">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" value="{{ $item->id }}" name="id">
                                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>
                                                        Xóa</button>
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
    @include('backend.payment_methods.handles.switchery')
    @include('backend.components.toastmsg');
    <script src="{{ asset('backend/js/framework/delete2.js') }}"></script>
    {{-- @include('backend.variants.handles.delete'); --}}
@endpush
