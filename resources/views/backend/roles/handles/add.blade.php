<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Cập nhật tất cả checkbox khi thay đổi checkbox "Chọn tất cả"
    document.getElementById('selectAllPermissions').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });

        // Cập nhật tất cả checkbox nhóm quyền
        const groupCheckboxes = document.querySelectorAll('.select-group-permission');
        groupCheckboxes.forEach(groupCheckbox => groupCheckbox.checked = this.checked);
    });

    // Khi checkbox nhóm quyền thay đổi, áp dụng cho các quyền trong nhóm đó
    const groupCheckboxes = document.querySelectorAll('.select-group-permission');
    groupCheckboxes.forEach(groupCheckbox => {
        groupCheckbox.addEventListener('change', function() {
            const groupId = this.getAttribute('data-group-id');
            const permissions = document.querySelectorAll(`.group-permission-${groupId}`);
            permissions.forEach(permission => permission.checked = this.checked);
        });
    });

    // Khi thay đổi bất kỳ checkbox quyền nào, cập nhật trạng thái của checkbox "Chọn tất cả" và checkbox nhóm
    const permissions = document.querySelectorAll('input[name="permissions[]"]');
    permissions.forEach(permission => {
        permission.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateGroupCheckbox(this);
        });
    });

    function updateSelectAllCheckbox() {
        const allPermissionsChecked = Array.from(permissions).every(checkbox => checkbox.checked);
        document.getElementById('selectAllPermissions').checked = allPermissionsChecked;
    }

    function updateGroupCheckbox(permission) {
        const groupId = permission.className.match(/group-permission-(\d+)/)[1];
        const groupPermissions = document.querySelectorAll(`.group-permission-${groupId}`);
        const groupCheckbox = document.querySelector(`.select-group-permission[data-group-id="${groupId}"]`);
        groupCheckbox.checked = Array.from(groupPermissions).every(checkbox => checkbox.checked);
    }
});


    $(document).ready(function() {

        $(".form-add").submit(function() {
            event.preventDefault();
            let _token = $("input[name='_token'").val()
            let data = new FormData(this);
            // const inputs = Array.from(this.querySelectorAll(".form-control"));
            // inputs.forEach(function(input){
            //         data.append(input.name,input.value.trim());

            // })

            data.append("_token", _token);

            $.ajax({
                url: '{{ route('admin.role.store') }}',
                type: "POST",
                dataType: "json",
                data: data,
                contentType: false,
                processData: false,
                success: function(res) {
                    toastMessage(res[1], res[0], '{{ route('admin.role') }}')

                },
                error: function(error) {

                    let errors = error.responseJSON.errors;
                    document.querySelectorAll(".message-error").forEach(function(e) {
                        console.log(e);
                        e.innerText = "";
                    })
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
