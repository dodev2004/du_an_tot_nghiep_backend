<script>
    $(document).on('submit', '.form-delete', function(e) {
    e.preventDefault();

    let form = $(this); // Form đang được submit
    let url = form.attr('action'); // Lấy URL từ thuộc tính action

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(), // Dữ liệu từ form
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Bản ghi đã bị xóa thành công!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload(); // Tải lại trang sau khi xóa
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đã có lỗi xảy ra',
                        text: 'Không thể xóa bản ghi này.',
                    });
                }
            });
        }
    });
});


</script>