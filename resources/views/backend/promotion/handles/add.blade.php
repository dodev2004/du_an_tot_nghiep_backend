<script>
    $(document).ready(function() {
        $(".form-add").submit(function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form

            let _token = $("input[name='_token']").val(); // Đảm bảo cú pháp đúng
            let data = new FormData();
            const inputs = Array.from(this.querySelectorAll(".form-control"));

            inputs.forEach(function(input) {
                data.append(input.name, input.value
            .trim()); // Lấy giá trị từ input và loại bỏ khoảng trắng thừa
            });

            data.append("_token", _token); // Thêm CSRF token vào dữ liệu

            $.ajax({
                url: '{{ route('admin.promotions.store') }}',
                type: "POST",
                dataType: "json",
                data: data,
                contentType: false,
                processData: false,
                success: function(res) {
                    // Đảm bảo rằng dữ liệu trả về từ server có cấu trúc đúng
                    if (res && res.message && res.status) {
                        toastMessage(res.message, res.status,
                            '{{ route('admin.promotions') }}');
                    } else {
                        console.error("Unexpected response format:", res);
                    }
                },
                error: function(error) {
                    let errors = error.responseJSON ? error.responseJSON.errors : {};

                    Object.keys(errors).forEach(function(key) {
                        const input = document.querySelector(
                        `input[name="${key}"]`);
                        const select = document.querySelector(
                            `select[name="${key}"]`);

                        if (input) {
                            const message = input.parentElement.querySelector("p");
                            if (message) {
                                message.innerText = errors[key][
                                0]; // Lấy thông báo lỗi đầu tiên
                            }
                        }

                        if (select) {
                            const message = select.parentElement.querySelector(
                                ".message-error");
                            if (message) {
                                message.innerText = errors[key][
                                0]; // Lấy thông báo lỗi đầu tiên
                            }
                        }
                    });
                }
            });
        });
    });
</script>
