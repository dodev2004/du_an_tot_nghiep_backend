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
                <button class="btn btn-success" type="submit">Thêm mới</button>
            </div>
        </div>

    </div>
    </div>

</form>
