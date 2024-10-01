@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link rel="stylesheet" href="{{ asset('backend/css/upload.css') }}">
    <style>
        .form-user_create .row .col-md-6 {
            flex: 0 0 auto !important;
            margin-bottom: 4px;

        }

        .form-user_create .row .col-md-6>p {
            margin: 0;
        }

        .select2-selection {}

        .select2-selection__rendered {
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            height: 34px !important;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
            padding: 6px 12px;
            color: #333;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0;
            border: 1px solid #e5e6e7;
        }

        .select2-container {
            width: 100% !important;


        }

        .select2-selection__rendered {
            padding: 0 !important;
        }
    </style>
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
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <form action="{{ route('admin.payment_methods.store') }}" method="POST"
                        class="form-user_catelogue_create" style="background-color: white; padding:40px" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <h2>Thêm phương thức thanh toán</h2>
                                <span>
                                    Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                                </span>

                            </div>
                            <div class="col-md-8 " style="padding:20px 0 0 50px">
                                <div class="row" style="display: flex; flex-wrap:wrap">

                                    <div class="form-group col-md-12">
                                        <label for="">Tên phương thức thanh toán *</label>
                                        <input type="text" name="name" value="" class="form-control">
                                        <p class=" text-danger"></p>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Mô tả</label>
                                        <textarea name="description" id="" cols="30" class="form-control" rows="10">
    
                            </textarea>

                                        <p class=" text-danger"></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <button class="btn  btn-primary">Thêm mới phương thức thanh toán</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        @include('backend.components.scripts');
        @include('backend.payment_methods.handles.add');
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".attribute_id").select2({

                });
            })
        </script>
    @endpush
