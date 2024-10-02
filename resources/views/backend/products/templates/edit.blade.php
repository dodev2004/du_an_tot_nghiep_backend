@extends("backend.index")
@section("style")
@include('backend.components.head')
<link rel="stylesheet" href="{{asset("backend/css/catelogue/custom.css")}}">
<link rel="stylesheet" href="{{asset("backend/css/customdropdown.css")}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
<div class="wrapper wrapper-content">
    <form action="" enctype="multipart/form-data" method="POST" class="form-seo" name="form-seo">
        @csrf
        @method("PUT")
    <div class="row">
        <div class="col-md-9">
            <div class="ibox-title">
                <h5>Thông tin chung</h5>
            </div>
            <input type="text" class="form-control" style="display: none" name="user_id" value="{{Auth::id()}}">
            <div class="ibox-content">
                    <div class="form-group">
                        <label>Tiêu đề danh mục </label>
                         <input type="text" value="{{$post["title"]}}" placeholder="Tiêu đề danh mục" name="title" class="form-control">
                         <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Mô tả ngắn</label>
                        <textarea cols="50" rows="50" class="form-control" name="description" id="editor">{{$post['description']}}</textarea>
                        <span style="display:block" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Nội dung </label>
                        <textarea cols="50" rows="50" class="form-control" name="content" id="editor">{{$post["content"]}}</textarea>
                        <span style="display:block" class="text-danger"></span>
                    </div>
               
            </div>
            <div class="ibox-title">
                <h5>Cấu hình nâng cao </h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <label for="">Từ khóa chính</label>
                   <input type="text" class="form-control" name="meta_keywords" value="{{$post["meta_description"]}}">
                   <span class="text-danger"></span>
                </div>
                <div class="seo_showup">
                    <p>Xem trước :</p>
                    <span class="seo_url">
                        http://127.0.0.1:5500/post.htm
                    </span>
                    <h2 class="seo_title">Tiêu đề danh mục bài viết</h2>
                   
                    <span class="seo_description">
                        Cung cấp 1 thẻ mô tả bằng cách sửa đoạn trích dẫn bên dưới. Nếu bạn không có thẻ mô tả, Google sẽ thử tìm 1 phần thích hợp trong bài viết của bạn để hiển thị cho kết quả tìm kiếm.
                    </span>
                </div>
                <div class="form-group">
                    <label for="">Đường dẫn</label>
                   <input type="text" class="form-control" name="slug" value="{{$post["slug"]}}">
                   <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Thẻ mô tả</label>
                    <textarea class="form-control" name="meta_description" id="" cols="30" rows="2">{{$post["meta_description"]}}</textarea>
                    <div class="description-meta">
                        <p id="meta-info"></p>
                    </div>
                    <span class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="ibox-content">
                        <div class="collapse_catelogue">
                            <span>Danh mục bài viết</span>
                            <i class="fa-solid fa-caret-right"></i>
                        </div>
                        <div class="collapse collapse-show">
                            @php 
                            echo $post_catelogues
                            @endphp 
                        </div>
                        <p class="message-error text-danger"></p>
                    <div>
                    <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="avatar_title">
                        <h5>Chọn ảnh đại diện</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                           <input type="text" name="avatar" class="form-control" id="avatar" class="avatar" style="display: none;">
                           <div class="seo_avatar" id="seo_avatar" >
                            @if(!empty($post["avatar"]))
                            <img class="" src="{{$post["avatar"]}}" alt="">
                            @else
                            <img class="" src="https://icon-library.com/images/no-image-icon/no-image-icon-0.jpg" alt="">
                           
                            @endif
                            
                           </div>
                           
                        </div>
                    </div>
                   
                </div>
                <div class="ibox-content">
                    <div class="avatar_title">
                        <h5>Cấu hình nâng cao</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                          <label for="">Trạng thái</label>
                          <select name="status" id="" class="form-control">
                            <option value="0" @if(!$post["status"]) selected @endif>Không kích hoạt</option>
                            <option value="1" @if($post["status"]) selected @endif>Kích hoạt</option>
                          </select>
                           
                        </div>
                        <div class="form-group">
                            <label for="">Flows</label>
                            <select name="flow" id="" class="form-control">
                                <option value="1">Xuất bản</option>
                              <option value="0">Bản nháp</option>
                             
                            </select>
                             
                          </div>
                    </div>  
                </div>
        </div>
    </div>
</form>
</div>
@endsection
@push("scripts")
@include('backend.components.scripts');
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset("backend/js/framework/ckfinder.js")}}"></script>
@include("backend.posts.components.post.js.ckfinder")
<script src="{{asset("backend/js/framework/seo.js")}}"></script>
<script src="{{asset("backend/js/framework/catelogue/select2.js")}}"></script>
@include("backend.posts.handle.posts.update");
<script src="{{asset('backend/js/collapse.js')}}"></script>
@endpush