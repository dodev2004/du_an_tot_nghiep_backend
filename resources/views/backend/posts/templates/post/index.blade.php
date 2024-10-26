@extends("backend.index")
@section("style")
@include('backend.components.head')
<link href="{{asset("backend/css/plugins/dataTables/datatables.min.css")}}" rel="stylesheet">

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
                <!-- <div class="ibox-title">
                <h5>{{$title}}</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div> -->
                <div class="ibox-content">
                    @include("backend.posts.components.post.fillter")
                    @include("backend.posts.components.post.table")
                    <div style="display:flex;justify-content: space-between;align-items: center">
                        <div class="per_page">
                            <p>Tồn tại tổng <strong>{{$data->count()}}</strong> tại trang thứ <strong>{{$data->currentPage()}}</strong></p>
                        </div>
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            {{ $data->appends(request()->query())->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
@include('backend.components.scripts');
@include("backend.components.handles.switchery");
@include('backend.components.toastmsg');
<script src="{{asset("backend/js/framework/delete2.js")}}"></script>
@include("backend.posts.handle.delete");
<script src="{{asset("backend/js/plugins/dataTables/datatables.min.js")}}"></script>
<script src="{{asset("backend/js/framework/table.js")}}"></script>

@endpush