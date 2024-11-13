<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allPermissionsCheckbox = document.getElementById('selectAllPermissions');
        const groupCheckboxes = document.querySelectorAll('.select-group-permission');
        const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

        // Kiểm tra và cập nhật trạng thái của checkbox "Chọn tất cả" và checkbox nhóm
        function initializeCheckboxes() {
            updateSelectAllCheckbox();
            groupCheckboxes.forEach(updateGroupCheckbox);
        }

        // Cập nhật trạng thái của checkbox "Chọn tất cả"
        function updateSelectAllCheckbox() {
            allPermissionsCheckbox.checked = Array.from(permissionCheckboxes).every(checkbox => checkbox
                .checked);
        }

        // Cập nhật trạng thái của checkbox nhóm
        function updateGroupCheckbox(groupCheckbox) {
            const groupId = groupCheckbox.getAttribute('data-group-id');
            const groupPermissions = document.querySelectorAll(`.group-permission-${groupId}`);
            groupCheckbox.checked = Array.from(groupPermissions).every(checkbox => checkbox.checked);
        }

        // Sự kiện cho checkbox "Chọn tất cả"
        allPermissionsCheckbox.addEventListener('change', function() {
            permissionCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
            groupCheckboxes.forEach(groupCheckbox => groupCheckbox.checked = this.checked);
        });

        // Sự kiện cho từng checkbox nhóm quyền
        groupCheckboxes.forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function() {
                const groupId = this.getAttribute('data-group-id');
                const groupPermissions = document.querySelectorAll(
                    `.group-permission-${groupId}`);
                groupPermissions.forEach(permission => permission.checked = this.checked);
                updateSelectAllCheckbox();
            });
        });

        // Sự kiện cho từng checkbox quyền
        permissionCheckboxes.forEach(permissionCheckbox => {
            permissionCheckbox.addEventListener('change', function() {
                const groupId = this.className.match(/group-permission-(\d+)/)[1];
                const groupCheckbox = document.querySelector(
                    `.select-group-permission[data-group-id="${groupId}"]`);
                updateGroupCheckbox(groupCheckbox);
                updateSelectAllCheckbox();
            });
        });

        // Khởi tạo trạng thái checkbox khi trang tải
        initializeCheckboxes();
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
                        // const checkboxes = document.querySelectorAll(
                        //     'input[name="permissions[]"]');
                        // const anyChecked = Array.from(checkboxes).some(checkbox =>
                        //     checkbox.checked);
                        // const errorMessageElement = document.querySelector(
                        //     '.message-error-permissions');

                        // if (!anyChecked) {
                        //     event.preventDefault(); // Ngăn gửi form
                        //     errorMessageElement.textContent =
                        //         'Vui lòng chọn ít nhất một quyền.';
                        // } else {
                        //     errorMessageElement.textContent =
                        //         ''; // Xoá thông báo lỗi nếu có ít nhất một quyền được chọn
                        // }
                    })
                }
            })
        })
    })
</script>
