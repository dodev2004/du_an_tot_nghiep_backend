<div class="container " style="margin-left: 100px;">

    <div class="contact-info mt-4">
        @if (isset($item))
            <input type="checkbox" value="{{ $item->id }}" hidden>
            <div class="mx-auto" style="width: 700px; display : flex ; padding:25px; justify-content:center;border-radius: 5px ; border : 1px solid gray;  flex-direction: column">
                <h1 style="text-align: center">Trang Liên Hệ </h1>
                <div style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px;">
                    <div>
                        <h4 style="text-align: center; padding-bottom: 12px;">Thông tin người hỗ trợ </h4>
                        <p><strong>Tên :</strong> {!! $item->name !!}</p>
                        <p><strong>Số điện thoại:</strong> {!! $item->phone !!}</p>
                        <p><strong>Địa chỉ:</strong> {!! $item->address !!}</p>
                    </div>
                    <div>
                        <h4 style="text-align: center">Ảnh địa chỉ</h4>
                        <img src="{{ $item->image }}" alt="" width="100%" height="250px" >
                    </div>
                </div>
                <div >
                    <h4>Bản Đồ</h4>
                    <div class="map">
                        <iframe src="{!! $item->map !!}" width="100%" height="250" style="border:0;"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
               <div style="display: flex; justify-content: end;margin-top: 10px ;">
                @if (isset($item))
                <a class="btn btn-sm btn-info" href="{{ route('admin.information.edit', $item->id) }}" style="width: 100px;" ><i class="fa fa-paste"></i>
                    Edit</a>

                @endif
               </div>

            </div>
        @endif

    </div>
</div>
