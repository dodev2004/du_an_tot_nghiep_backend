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

    // Cập nhật thông tin vào modal
    $('#userFullName').text(userFullName);
    $('#userEmail').text(userEmail);
    $('#userName').text(userName);
    $('#userPhone').text(userPhone);
    $('#userAddress').text(userAddress);
    $('#userBirthday').text(userBirthday);
    $('#userProvince').text(userProvince);
    $('#userDistrict').text(userDistrict);
    $('#userWard').text(userWard);
    $('#userAvatar').attr('src', userAvatar);

    // Mở modal
    $('#userDetailModal').modal('show');
});

</script>