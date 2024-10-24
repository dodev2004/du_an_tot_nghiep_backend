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
         
            
            <div class="ibox-content">
                
                @include("backend.trash.trash_comment.components.fillter")
                @include("backend.trash.trash_comment.components.table")
                @include("backend.trash.trash_comment.components.page")
                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                {{ $data->links() }}
                </div>
            </div>
        </div>

    </div>
    </div>
</div>

@endsection
@push("scripts")
@include('backend.components.scripts');
@include("backend.posts.handle.switchery")
@include('backend.components.toastmsg');
<script src="{{asset("backend/js/framework/delete2.js")}}"></script>
@include("backend.trash.trash_comment.handles.delete");
@endpush
