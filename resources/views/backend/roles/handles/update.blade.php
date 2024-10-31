<script>
    // Hàm kiểm tra trạng thái của tất cả checkbox quyền
    function updateSelectAllCheckbox() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        const selectAllCheckbox = document.getElementById('selectAllPermissions');

        // Kiểm tra nếu tất cả checkbox quyền đều được chọn
        const allChecked = Array.from(checkboxes).every((checkbox) => checkbox.checked);
        selectAllCheckbox.checked = allChecked;
    }

    // Kiểm tra khi tải trang
    window.addEventListener('DOMContentLoaded', (event) => {
        updateSelectAllCheckbox();

        // Lắng nghe sự thay đổi của tất cả checkbox quyền
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', updateSelectAllCheckbox);
        });
    });

    // Khi checkbox "Chọn tất cả" thay đổi, áp dụng cho tất cả checkbox quyền
    document.getElementById('selectAllPermissions').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });

    $(document).ready(function() {


        $(".form-update").submit(function() {
            event.preventDefault();
            let _token = $("input[name='_token'").val()
            let data = new FormData(this);
            //    const inputs = Array.from(this.querySelectorAll(".form-control"));
            //    inputs.forEach(function(input){
            //         data.append(input.name,input.value);
            //    })
            data.append("_token", _token);
            console.log(data);
            $.ajax({
                url: '{{ route('admin.role.update', $id) }}',
                type: "POST",
                dataType: "json",
                data: data,
                contentType: false,
                processData: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(res) {

                    toastMessage(res[1], res[0], '{{ route('admin.role') }}')

                },
                error: function(error) {
                    let errors = error.responseJSON.errors;
                    Object.keys(errors).forEach(function(error) {
                        const input = document.querySelector(
                            `input[name="${error}"]`);
                        const select = document.querySelector(
                            `select[name="${error}[]"]`)
                        const textarea = document.querySelector(
                            `textarea[name="${error}"]`)

                        if (input) {
                            const message = input.parentElement.querySelector("p");
                            message.innerText = errors[error]

                        }
                        if (select) {
                            const message = select.parentElement.querySelector(
                                ".message-error");
                            message.innerText = errors[error]

                        }
                        if (textarea) {
                            const message = textarea.parentElement.querySelector(
                                ".text-danger");
                            console.log(message);
                            message.innerText = errors[error]
                        }
                        const checkboxes = document.querySelectorAll(
                            'input[name="permissions[]"]');
                        const anyChecked = Array.from(checkboxes).some(checkbox =>
                            checkbox.checked);
                        const errorMessageElement = document.querySelector(
                            '.message-error-permissions');

                        if (!anyChecked) {
                            event.preventDefault(); // Ngăn gửi form
                            errorMessageElement.textContent =
                                'Vui lòng chọn ít nhất một quyền.';
                        } else {
                            errorMessageElement.textContent =
                            ''; // Xoá thông báo lỗi nếu có ít nhất một quyền được chọn
                        }
                    })
                }
            })
        })
    })
</script>
