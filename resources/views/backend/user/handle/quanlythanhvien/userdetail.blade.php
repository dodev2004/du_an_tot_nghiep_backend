<script>
    $(document).on('click', '.view-user-detail', function() {
    // Lấy thông tin người dùng từ thuộc tính data
    var userFullName = $(this).data('full-name');
    var userEmail = $(this).data('email');
    var userName = $(this).data('username');
    var userPhone = $(this).data('phone');
    var userAddress = $(this).data('address');
    var userBirthday = $(this).data('birthday');
    var userProvince = $(this).data('province');
    var userDistrict = $(this).data('district');
    var userWard = $(this).data('ward');
    var userAvatar = $(this).data('avatar');
    var created_at = $(this).data('created_at');

    // Cập nhật thông tin vào modal
    $('#userFullName').text(userFullName ? userFullName : 'Dữ liệu chưa có');
    $('#userEmail').text(userEmail ? userEmail : 'Dữ liệu chưa có');
    $('#userName').text(userName ? userName : 'Dữ liệu chưa có');
    $('#userPhone').text(userPhone ? userPhone : 'Dữ liệu chưa có');
    $('#userAddress').text(userAddress ? userAddress : 'Dữ liệu chưa có');
    $('#userBirthday').text(userBirthday ? userBirthday : 'Dữ liệu chưa có');
    $('#userProvince').text(userProvince ? userProvince : 'Dữ liệu chưa có');
    $('#userDistrict').text(userDistrict ? userDistrict : 'Dữ liệu chưa có');
    $('#userWard').text(userWard ? userWard : 'Dữ liệu chưa có');
    $('#created_at').text(created_at ? created_at : 'Dữ liệu chưa có');
    if (userAvatar) {
        $('#userAvatar').attr('src', userAvatar);
        $('#avatarMessage').text(''); // Xóa thông báo nếu có hình ảnh
    } else {
        $('#userAvatar').attr('src', ''); // Đặt src rỗng nếu không có hình ảnh
        $('#avatarMessage').text('Người dùng chưa có ảnh đại diện');
    }
    // Mở modal
    $('#userDetailModal').modal('show');
});

</script>
