<form action="{{ route('admin.contact.store') }}" method="POST" class="form-add"
    style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <div class="form-group">
                    <label>Tiêu đề </label>
                    <input type="text" placeholder="" name="title" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea cols="50" rows="50" class="form-control" name="content" id="editor"></textarea>
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="ibox-content">
                    <div class="avatar_title">
                        <h5>Chọn ảnh đại diện</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <input type="text" name="image" class="form-control" id="avatar" class="avatar"
                                style="display: none;">
                            <div class="seo_avatar" id="seo_avatar">
                                <img class="" src="https://icon-library.com/images/no-image-icon/no-image-icon-0.jpg"
                                    alt="" width="50px">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" style="display: flex; flex-wrap:wrap">
                    <div class="ibox-content">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

</form>
