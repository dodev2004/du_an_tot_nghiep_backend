<script>
    $(document).on('click', '.view-user-detail', function() {
    // Lấy thông tin người dùng từ thuộc tính data
    var userFullName = $(this).data('full-name');
    var userEmail = $(this).data('email');
    var userName = $(this).data('username');
    var userPhone = $(this).data('phone');
    var userAddress = $(this).data('address');
    var content = $(this).data('content');
    var image = $(this).data('image');
    var response = $(this).data('response');
    var updated_at = $(this).data('updated_at');

    // Cập nhật thông tin vào modal
    $('#userFullName').text(userFullName);
    $('#userEmail').text(userEmail);
    $('#userName').text(userName);
    $('#userPhone').text(userPhone);
    $('#userAddress').text(userAddress);
    $('#response').text(response);
    $('#updated_at').text(updated_at);
    $('#content').text(content);
    // Kiểm tra xem hình ảnh có tồn tại hay không
    if (image) {
        $('#image').attr('src', image);
        $('#imageMessage').text(''); // Xóa thông báo nếu có hình ảnh
    } else {
        $('#image').attr('src', ''); // Đặt src rỗng nếu không có hình ảnh
        $('#imageMessage').text('Người dùng không gửi tệp đính kèm nào');
    }

    // Mở modal
    $('#userDetailModal').modal('show');
});

</script>
