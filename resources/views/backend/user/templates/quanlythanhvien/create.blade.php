@extends('backend.index')
@section('style')
    @include('backend.components.head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/css/upload.css') }}">
    <style>
        .form-user_create .row .col-md-6 {
            flex: 0 0 auto !important;
            margin-bottom: 4px;

        }

        .form-user_create .row .col-md-6>p {
            margin: 0;
        }
    </style>
@endsection
@section('title')
    {{ $title }}
@endsection
@section('content')
    @include('backend.components.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        <form action="{{ route('admin.users.store') }}" method="POST" class="form-user_create"
            style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h2>Thôn tin tài khoản</h2>
                    <span>
                        Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                    </span>
                    <div class="upload" style="margin-top: 10px">
                        <label for="upload-file">Thêm ảnh đại diện tại đây</label>
                        <input type="file" data-upload="avatar" name="avatar" id="upload-file" class="form-control">
                    </div>
                    <div class="show-image">
                        <img width="100" height="100" src="" alt="">
                    </div>
                </div>
                <div class="col-md-8 " style="padding:20px 0 0 50px">
                    <div class="row" style="display: flex; flex-wrap:wrap">
                        <div class="form-group col-md-6">
                            <label for="">Email *</label>
                            <input type="email" name="email" class="form-control" value="" autocomplete="">
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Fullname *</label>
                            <input type="text" name="full_name" class="form-control" value="" autocomplete="">
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">username *</label>
                            <input type="text" name="username" value="" class="form-control">
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Mật khẩu *</label>
                            <input type="password" name="password" value="" class="form-control">
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Nhập lại mật khẩu *</label>
                            <input type="password" name="re-password" value="" class="form-control">
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Vai trò *</label>
                            <select class="form-control roles" name="role_id" id="" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Ngày sinh</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date"
                                    name="birthday" class="form-control">
                            </div>
                            <p class=" text-danger"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 50px">
                <div class="col-md-4">
                    <h2>Thôn tin liên hệ</h2>
                    <span>
                        Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                    </span>
                </div>
                <div class="col-md-8 " style="padding:20px 0 0 50px">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Thành phố </label>
                            @if (isset($provinces))
                                <select class="province form-control" name="province_id">
                                    <option selected value="">Vui lòng chọn thành phố</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Quận (Huyện)</label>
                            <select class="district form-control" name="district_id">
                                <option selected value="">Vui lòng chọn quận huyện</option>
                            </select>
                            <p class=" text-danger"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phường (Xã)</label>
                            <select class="ward form-control" name="ward_id" id="">
                                <option value="">Vui lòng chọn phường</option>

                            </select>
                            <p class=" text-danger"></p>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Địa chỉ</label>
                            <input type="text" name="address" class="form-control">
                            <p class=" text-danger"></p>

                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                            <p class=" text-danger"></p>

                        </div>
                    </div>

                </div>
            </div>
            <div class="text-right mt-4">
                <button class="btn  btn-primary">Thêm mới thành viên</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    @include('backend.components.scripts');
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend/js/uploadfile.js') }}"></script>
    @include('backend.user.handle.quanlythanhvien.add');
    @include('backend.user.handle.quanlythanhvien.selectTwo');
@endpush
