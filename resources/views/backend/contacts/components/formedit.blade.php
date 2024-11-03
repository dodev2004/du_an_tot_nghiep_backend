<div class="row">
    <div class="col-md-9">
        <div class="ibox-content">
            <div class="form-group">
                <h1>{{ $data->title }}</h1>
            </div>
            <div class="form-group">
                <label>tài khoản </label>
                <input type="text" value="{{ $user->username }}" name="username" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="text" value="{{ $user->email }}" name="email" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>địa chỉ</label>
                <input type="text" value="{{ $user->address }}" name="address" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>số điện thoại</label>
                <input type="text" value="{{ $user->phone }}" name="phone" class="form-control" readonly>
            </div>
            <div class="form-group">
                @if($data->image)
                <label>Hình ảnh</label>
                    <img src="{{ Storage::url($data->image) }}" alt="image" width="50px">
                @endif
            </div>
            <div class="form-group">
                <label>nội dung</label>
                {{-- <input type="text" value="{{ $data->content }}" name="content" class="form-control" readonly> --}}
                <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $data->content }}</textarea>
            </div>
            <form action="{{ route('admin.contact.update', $data->id) }}" method="POST" class="form-update"
                style="background-color: white" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>phản hồi của nhân viên</label>
                    <textarea name="response" id="" cols="120" rows="10" class="form-control"
                        placeholder="phản hồi khách hàng" @if (isset($data->response)&&!$data->response=='') readonly @endif>@if (isset($data->response)){{ $data->response }}@endif</textarea>
                    <p class=" text-danger message-error"></p>
                </div>
                <div class="row text-right mt-4">
                    <button class="btn btn-primary">Phản hồi</button>
                </div>
            </form>

        </div>
    </div>

</div>
