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

        .permission-group {
            margin-bottom: 15px;
        }

        .permissions-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Khoảng cách giữa các quyền */
        }

        .permissions-list .form-check {
            width: auto;
            /* Để mỗi quyền tự động co giãn */
        }
    </style>
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    @include('backend.components.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('backend.roles.components.formadd')
    </div>
@endsection
@push('scripts')
    @include('backend.components.scripts');
    <script src="{{ asset('backend/js/framework/ckfinder.js') }}"></script>
    @include('backend.roles.handles.add');

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('backend/js/framework/seo.js') }}"></script>
    <script src="{{ asset('backend/js/framework/catelogue/select2.js') }}"></script>



    <script>
        $(document).ready(function() {
            $(".attribute_id").select2({

            });
        })
    </script>
@endpush
