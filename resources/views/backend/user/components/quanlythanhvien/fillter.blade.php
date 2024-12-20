<div class="ibox-content_top">

    <div class="form_seach">
        @php

        @endphp
        <input type="text" class="form-control" name="seach_text" @if(isset($_GET["name"])) value="{{$_GET['name']}}" @endif placeholder="Tìm kiếm theo tên">
        <select type="text" class="form-control" name="seach_rule" placeholder="Tìm kiếm theo vai trò">
            <option value="" {{ request('rule_id') == "" ? 'selected' : '' }}>Toàn bộ</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ request('rule_id') == "$role->id" ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        <a class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </a>
        <a href="{{route("admin.users.create")}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm người dùng</a>
    </div>
    <div class="total_record">

        <div style="margin-top: 15px;">
            <a href="{{ route('admin.users.trash') }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                title="Thùng rác"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
</div>
