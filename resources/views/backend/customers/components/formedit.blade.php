<form action="{{route("admin.customer.update",$data->id)}}" method="POST" class="form-update" style="background-color: white; padding:40px" novalidate enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-md-4">
                <h2>Thông tin tài khoản</h2>
                <span>
                    Những trường có dấu ("*") là những trường bắt buộc và không được bỏ trống
                </span>
                <div>
                    <div class="avatar_title">
                        <h5>Chọn ảnh đại diện</h5>
                    </div>

                        <div class="form-group">
                            <input type="text" name="avatar" class="form-control" id="avatar" class="avatar"
                                style="display: none;">
                            <div class="seo_avatar" id="seo_avatar">
                                <img class="" src="https://icon-library.com/images/no-image-icon/no-image-icon-0.jpg"
                                    alt="" width="50px">
                                @if ($data->avatar)
                                    <img src="{{ $data->avatar }}" alt="Current Avatar" width="50px">
                                @endif
                            </div>
                        </div>


                </div>
        </div>
        <div class="col-md-8 " style="padding:20px 0 0 50px">
            <div class="row" style="display: flex; flex-wrap:wrap">
                <div class="form-group col-md-6">
                    <label for="">Email *</label>
                    <input type="email"  name="email" value="{{$data->email}}" class="form-control" autocomplete="">
                    <p  class=" text-danger"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Fullname *</label>
                    <input type="text" name="full_name" class="form-control" value="{{$data->full_name}}" autocomplete="">
                    <p class=" text-danger"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="">username *</label>
                    <input type="text" name="username" value="{{$data->username}}" class="form-control">

                   <p  class=" text-danger"></p>

                </div>
                <div class="form-group col-md-6">
                    <label for="">Ngày sinh</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" value="{{$data->birthday}}" name="birthday" class="form-control">
                    </div>
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
            <div class="form-group col-md-6">
                <label for="">Thành phố </label>
                @if(isset($provinces))
                <select class="province form-control" name="province_id">
                    <option selected value="">Vui lòng chọn thành phố</option>
                    @foreach($provinces as $province)
                    <option @if($province->code == $data->province_id) selected @endif value={{$province->code}}>{{$province->name}}</option>
                    @endforeach
                  </select>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="">Quận (Huyện)</label>
                <select class="district form-control" name="district_id">
                    <option  selected value="">Vui lòng chọn quận huyện</option>
                    @if(!empty($districts))
                    @foreach($districts as $district)
                    <option @if($district->code == $data->district_id) selected @endif value={{$district->code}}>{{$district->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Phường (Xã)</label>
                <select class="ward form-control" name="ward_id" id="">
                    <option value="">Vui lòng chọn phường</option>
                    @if(!empty($wards))
                    @foreach($wards as $ward)
                    <option @if($ward->code == $data->ward_id) selected @endif value={{$ward->code}}>{{$ward->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{$data->address}}">
            </div>
            <div class="form-group col-md-12">
                <label for="">Số điện thoại</label>
                <input type="text" value="{{$data->phone}}" name="phone" class="form-control">
            </div>
        </div>
    </div>
    <div class="text-right mt-4">
          <button class="btn  btn-primary">sửa thành viên</button>
    </div>

</form>
