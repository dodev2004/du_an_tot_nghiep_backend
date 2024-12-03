@extends("backend.index")
@section("style")
@include('backend.components.head')
<link rel="stylesheet" href="{{asset("backend/css/catelogue/custom.css")}}">
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
    <form action="{{route('admin.post-catelogue.store')}}" enctype="multipart/form-data" method="POST" class="form-seo" name="form-seo">
        @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="ibox-title">
                <h5>Thông tin chung</h5>
            </div>
            <input type="text" class="form-control" style="display: none" name="user_id" value="{{Auth::id()}}">
            <div class="ibox-content">
                
                    <div class="form-group">
                        <label>Tiêu đề danh mục </label>
                         <input type="text" placeholder="Tiêu đề danh mục" name="name" value="{{$post_catelogues->name}}" class="form-control">
                         <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Mô tả ngắn</label>
                        <textarea cols="50" rows="50" class="form-control" name="description" id="editor">
                            {{$post_catelogues->description}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung </label>
                        <textarea cols="50" rows="50" class="form-control" name="content" id="editor">
                            {{$post_catelogues->content}}   
                        </textarea>
                    </div>
               
            </div>
            <div class="ibox-title">
                <h5>Cấu hình nâng cao </h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <label for="">Từ khóa chính</label>
                   <input type="text" class="form-control" value="{{$post_catelogues->meta_keywords}}" name="meta_keywords">
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
                   <input type="text" class="form-control" name="slug">
                   <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Thẻ mô tả</label>
                    <textarea class="form-control" name="meta_description" id="" cols="30" rows="2">
                        {{$post_catelogues->meta_description}}
                    </textarea>
                    <div class="description-meta">
                        <p id="meta-info"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
                <div class="ibox-content">
                    <div class="form-group">
                        <label for="">Danh mục cha</label>
                        <p>Nếu chọn  root thì sẽ là danh mục gốc</p>
                        <select name="parent_id" class="form-control" id="">
                            <option value="">Có tồn tại danh mục cha</option>
                            <option value="0" selected>Root</option>
                            @php 
                            echo $catelogues
                            @endphp 
                        </select>
                        <p class="message-error text-danger"></p>
                    </div>
                    <div>
                    <button class="btn btn-success" type="submit">Cập nhật</button>
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
                            @empty($post_catelogues->avatar)
                            <img class="" src="https://icon-library.com/images/no-image-icon/no-image-icon-0.jpg" alt="">
                            @endempty
                            @empty(!$post_catelogues->avatar)
                            <img class="" src="{{$post_catelogues->avatar}}" alt="">
                            @endempty
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
                            <option @if($post_catelogues->status == 0) selected @endif value="0">Không kích hoạt</option>
                            <option @if($post_catelogues->status == 1) selected @endif value="1">Kích hoạt</option>
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
@include("backend.posts.components.post_catelogue.js.ckfinder")
<script src="{{asset("backend/js/framework/seo.js")}}"></script>
<script src="{{asset("backend/js/framework/catelogue/select2.js")}}"></script>
@include("backend.posts.handle.post_catelogue.update");
@endpush