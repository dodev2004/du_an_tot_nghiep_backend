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
    $('#userFullName').text(userFullName ?: 'không có dữ liệu');
    $('#userEmail').text(userEmail ?: 'không có dữ liệu');
    $('#userName').text(userName ?: 'không có dữ liệu');
    $('#userPhone').text(userPhone ?: 'không có dữ liệu');
    $('#userAddress').text(userAddress ?: 'không có dữ liệu');
    $('#response').text(response ?: 'không có dữ liệu');
    $('#updated_at').text(updated_at ?: 'không có dữ liệu');
    $('#content').text(content ?: 'không có dữ liệu');
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
