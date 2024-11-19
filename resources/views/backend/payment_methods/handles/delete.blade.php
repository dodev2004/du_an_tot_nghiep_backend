<script>
    window.onload = function() {
        const forms = document.querySelectorAll(".form-delete");

        forms.forEach(form => {
            form.addEventListener("submit", handleSubmit);
        });

        function handleSubmit(event) {
            event.preventDefault();
            const textUrl = this.dataset.url.trim();
            const id = this.querySelector(`input[name=id]`).value;
            const _token = document.querySelector("input[name=_token]").value;

            const url = `{{ url('admin') }}/${textUrl}/delete`;

            const element = this.parentElement.parentElement;
            const tbodyElement = element.parentElement;
            const data = {
                id,
                _token
            };


            Swal.fire({
                title: 'Bạn có muốn xóa',
                text: "Bạn se không thể hoàn tác hành động này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đúng tôi muốn xóa!'
            }).then((result) => {
                if (result.isConfirmed) {

                    alertleDelete(data, element, tbodyElement, url);
                }
            });
        }

        function alertleDelete(data, element, tbodyElement, url) {

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify({
                        id: data.id
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            result.message,
                            'success'
                        );
                        tbodyElement.removeChild(element);
                    } else {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Could not connect to the server.',
                        'error'
                    );
                });
        }
    }
</script>
