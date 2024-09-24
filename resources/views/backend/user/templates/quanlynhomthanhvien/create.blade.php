@extends("backend.index")
@section("style")
@include('backend.components.head')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset("backend/css/upload.css")}}">
<style>
    .form-user_create .row .col-md-6{
    flex: 0 0 auto !important;
    margin-bottom: 4px;

}
.form-user_create .row .col-md-6 > p{
    margin: 0;
}
</style>
@endsection
@section("title")
{{$title}} 
@endsection
@section("content")
@include("backend.components.breadcrumb")
<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route("admin.users.store")}}" method="POST" class="form-user_catelogue_create" style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
                    <h2>Thôn tin về nhóm tài khoản</h2>
                    <span>
                        Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                    </span>
        
            </div>
            <div class="col-md-8 " style="padding:20px 0 0 50px">
                <div class="row" style="display: flex; flex-wrap:wrap">
                   
                    <div class="form-group col-md-12">
                        <label for="">Tên nhóm thành viên *</label>
                        <input type="text" name="name" value="" class="form-control">
                       <p  class=" text-danger"></p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Mô tả</label>
                        <textarea name="description" id="" cols="30" class="form-control" rows="10">

                        </textarea>
                    
                        <p  class=" text-danger"></p>
                       
                    </div> 
                </div>
            </div>
        </div>
        <div class="text-right mt-4">
              <button class="btn  btn-primary">Thêm mới nhóm thành viên</button>
        </div>
      
    </form>
</div>
@endsection

@push("scripts")
@include('backend.components.scripts');
@include('backend.user.handle.quanlynhomthanhvien.add');


@endpush