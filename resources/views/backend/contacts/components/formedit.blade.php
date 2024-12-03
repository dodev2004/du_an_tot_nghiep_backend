<div class="row" style="display: flex; justify-content: center; padding: 20px;background-color: #fff;">
    <div class="col-md-9" style="width: 100%; max-width: 900px; background-color: #fff; padding: 20px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); border-radius: 10px; margin: 20px 0;">
        <div class="ibox-content" style="padding: 20px; background-color: #fff; border: 1px solid #e5e5e5; border-radius: 8px;">
            <div class="form-group" style="margin-bottom: 15px;">
                <h1 style="font-size: 28px; font-weight: bold; color: #333; margin-bottom: 20px;">{{ $data->title }}</h1>
            </div>
           <div style="display : flex; gap: 10px;">
           <div class="form-group" style="margin-bottom: 15px;width: 100%;cursor: not-allowed;">
                <label>Tài khoản</label>
                <input type="text" value="{{ $user->username }}" name="username" class="form-control" readonly style="cursor: not-allowed;width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;width: 100%;cursor: not-allowed;">
                <label>Email</label>
                <input type="text" value="{{ $user->email }}" name="email" class="form-control" readonly style="cursor: not-allowed;width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
           </div>
            <div style="display : flex; gap: 10px;">
            <div class="form-group" style="margin-bottom: 15px;width: 100%;cursor: not-allowed;">
                <label>Địa chỉ</label>
                <input type="text" value="{{ $user->address }}" name="address" class="form-control" readonly style="cursor: not-allowed;width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;width: 100%;cursor: not-allowed;">
                <label>Số điện thoại</label>
                <input type="text" value="{{ $user->phone }}" name="phone" class="form-control" readonly style="cursor: not-allowed;width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            </div>

            <div style="display: flex; gap: 20px; align-items: flex-start;">
    <div class="form-group" style="margin-bottom: 15px; margin-top : 5px; width: 100%;">
        <label style="font-weight: bold; margin-bottom: 5px; display: block;cursor: not-allowed;">Nội dung</label>
        <textarea name="content" cols="30" rows="10" class="form-control" readonly style="width: 100%; height : 180px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9; resize: none;cursor: not-allowed;">{{ $data->content }}    </textarea>
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        @if($data->image)
        <label style="font-weight: bold; margin-bottom: 5px; display: block;">Hình ảnh</label>
        <img src="{{ Storage::url($data->image) }}" alt="image" width="250px" style="display: block; margin-top: 10px; border-radius: 4px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        @endif
    </div>
</div>
            <form action="{{ route('admin.contact.update', $data->id) }}" method="POST" class="form-update" style="background-color: white; padding: 10px; border: 1px solid #ccc; border-radius: 8px;" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Phản hồi của nhân viên</label>
                    <textarea name="response" cols="120" rows="10" style=" resize: none;" class="form-control" placeholder="phản hồi khách hàng" @if (isset($data->response) && !$data->response=='') readonly @endif style="width: 100%; padding: 10px;display: block; border: 1px solid #ccc; border-radius: 4px;">@if (isset($data->response)){{ $data->response }}@endif</textarea>
                    <p class="text-danger message-error" style="color: red;"></p>
                </div>
                <div class="row text-right mt-4" style="text-align: right; margin-top: 20px;">
                    <button class="btn btn-primary" style="background-color: #007bff; border: none; padding: 10px 20px; color: white; border-radius: 4px; cursor: pointer;">Phản hồi</button>
                </div>
            </form>
        </div>
    </div>
</div>
