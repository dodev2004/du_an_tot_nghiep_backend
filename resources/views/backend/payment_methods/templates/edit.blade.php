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
    <form action="{{ route('admin.payment_methods.update', $paymentMethods->id) }}" method="POST" class="form-update"
        style="background-color: white; padding:40px" novalidate>
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <h2>Thông tin phương thức thanh toán</h2>
                <span>
                    Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                </span>

            </div>
            <div class="col-md-8" style="padding:20px 0 0 50px">
                <div class="row" style="display: flex; flex-wrap:wrap">
                    <div class="form-group col-md-6">
                        <label for="">Tên phương thức thanh toán*</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="Nhập tên phương thức thanh toán " value="{{ $paymentMethods->name }}">
                        <p class=" text-danger message-error"></p>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Mô tả</label>
                        <textarea name="description" cols="30" class="form-control" rows="10"
                       > {{$paymentMethods->description}}
                        </textarea>

                        <p class=" text-danger"></p>

                    </div>

                </div>
            </div>
        </div>
        <div class="row text-right mt-4">
            <button type="submit" class="btn btn-primary">Sửa</button>
        </div>
    </form>
@endsection
@push("scripts")
@include('backend.components.scripts');
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset("backend/js/framework/ckfinder.js")}}"></script>
@include("backend.payment_methods.components.js.ckfinder")
<script src="{{asset("backend/js/framework/seo.js")}}"></script>
<script src="{{asset("backend/js/framework/catelogue/select2.js")}}"></script>
@include("backend.payment_methods.handles.update");
@endpush
