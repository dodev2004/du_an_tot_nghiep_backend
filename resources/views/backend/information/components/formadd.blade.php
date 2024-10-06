<form action="{{ route('admin.information.store') }}" method="POST" class="form-add"
    style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="ibox-content">
                <div class="form-group">
                    <label>tên </label>
                    <input type="text" placeholder="nhập tên" name="name" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>sdt</label>
                    <input type="text" placeholder="nhập sdt" name="phone" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>địa chỉ</label>
                    <input type="text" placeholder="nhập địa chỉ" name="address" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>map</label>
                    <textarea cols="50" rows="50" class="form-control" name="map" id="editor"></textarea>
                    <p class=" text-danger message-error"></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">

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

</form>
