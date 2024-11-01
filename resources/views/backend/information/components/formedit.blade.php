<form action="{{ route('admin.information.update', $data->id) }}" method="POST" class="form-update"
    style="background-color: white; padding: 40px;" novalidate enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-9">
            <div class="ibox-content">
                <div class="form-group">
                    <label>tên </label>
                    <input type="text" value="{{ $data->name }}" name="name" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>sdt</label>
                    <input type="text" value="{{ $data->phone }}" name="phone" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>địa chỉ</label>
                    <input type="text" value="{{ $data->address }}" name="address" class="form-control">
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="form-group">
                    <label>map</label>
                    <textarea cols="50" rows="50" class="form-control" name="map" id="editor">{{ $data->map }}</textarea>
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
                            @if ($data->image)
                                <img src="{{ $data->image }}" alt="Current Avatar" width="50px">
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="ibox-content">
                    <button class="btn btn-success" type="submit">Sửa</button>
                </div>
            </div>

        </div>
    </div>

</form>
