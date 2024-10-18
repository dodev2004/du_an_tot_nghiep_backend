@extends("backend.index")
@section("style")
@include('backend.components.head')
<link rel="stylesheet" href="{{asset("backend/css/customize.css")}}">
@endsection
@section("title")
{{$title}}
@endsection
@section("content")
   @include("backend.components.breadcrumb")
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h5>{{$title}}</h5>
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
                <style>
                    .form-group {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 10px;
                    }
                    .btn {
                        height: 30px;
                    }
                </style>
                @include("backend.roles.components.fillter")
                    @include("backend.roles.components.table")


                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                    {{  $roles->appends(request()->query())->links()}}
                </div>
            </div>
        </div>

    </div>
    </div>
    <p>Tồn tại tổng <strong>{{ $roles->count() }}
    </strong> tại trang thứ <strong>{{ $roles->currentPage() }}</strong>
</p>
</div>

@endsection
@push("scripts")
@include('backend.components.scripts');

@include('backend.components.toastmsg');
<script src="{{asset("backend/js/framework/delete2.js")}}"></script>
@include("backend.components.handles.delete");

@endpush