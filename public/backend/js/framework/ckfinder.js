
window.renderCkfinder = function () {

    const editor = document.querySelectorAll("#editor");
    console.log(editor);
    editor.forEach(function (editor) {
        ClassicEditor.create(editor, {
            ckfinder: {
                // Upload the images to the server using the CKFinder QuickUpload command.
                uploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

                // Define the CKFinder configuration (if necessary).
                options: {
                    resourceType: 'Images'
                }
            },
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'subscript',
                    'superscript',
                    'alignment',
                    '|',
                    'fontFamily',
                    'fontSize',
                    'fontColor',
                    'fontBackgroundColor',
                    'highlight',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'link',
                    'imageInsert',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'code',
                    'specialCharacters',
                    '|',
                    'undo',
                    'redo',
                    '|',
                    'CKFinder'
                ],
                shouldNotGroupWhenFull: true,
            },
            language: 'en',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side',
                    'linkImage'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            licenseKey: '',
            allowedContent: true, // Hoặc chỉ cụ thể với iframe
             extraAllowedContent: 'iframe[*]',
             disallowedContent: '',  htmlSupport: {
                allow: [
                    {
                        name: 'iframe',
                        attributes: {
                            // Bạn có thể chỉ định các thuộc tính nào được cho phép
                            width: true,
                            height: true,
                            src: true,
                            // ...
                        }
                    }
                ]
            }


        })
            .then(editor => {
                window.editor = editor;
                CKFinder.setupCKEditor(editor);
                console.log(Array.from(editor.ui.componentFactory.names()));
            })
            .catch(error => {

                console.error(error);
            });
    })

}
var uploadImage = function (target = 'avatar') {
    if(target == "avatar"){
        var button1 = document.getElementById('seo_avatar');
        button1.onclick = function () {
            selectFileWithCKFinder('avatar');
        };

        function selectFileWithCKFinder(elementId) {
            CKFinder.popup({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        var file = evt.data.files.first();
                        var output = document.getElementById(elementId);
                        var image = document.querySelector(".seo_avatar > img");

                        // Cập nhật URL ảnh
                        image.src = file.getUrl();
                        output.value = file.getUrl();

                        // Thêm nút "✖" nếu chưa có
                        addRemoveButton();
                    });

                    finder.on('file:choose:resizedImage', function (evt) {
                        var output = document.getElementById(elementId);
                        output.value = evt.data.resizedUrl;
                        var image = document.querySelector(".seo_avatar > img");
                        image.src = evt.data.resizedUrl;

                        // Thêm nút "✖" nếu chưa có
                        addRemoveButton();
                    });
                }
            });
        }

        // Hàm thêm nút "✖" để xóa ảnh
        function addRemoveButton() {
            // Kiểm tra nếu nút "✖" đã có thì không thêm lại
            if (!document.querySelector('.seo_avatar .remove-avatar-btn')) {
                var removeButton = document.createElement('span');
                removeButton.classList.add('remove-avatar-btn');
                removeButton.innerHTML = '✖';

                // Xử lý sự kiện xóa ảnh khi nhấn nút "✖"
                removeButton.onclick = function() {
                    var image = document.querySelector(".seo_avatar > img");
                    image.src = 'https://icon-library.com/images/no-image-icon/no-image-icon-0.jpg';
                    document.getElementById('avatar').value = ''; // Xóa URL trong input
                    removeButton.remove(); // Xóa nút "✖"
                };

                document.querySelector('.seo_avatar').appendChild(removeButton);
            }
        }
    }
}

const removeAvatar = document.querySelector(".remove_avatar");
if(removeAvatar){
    const inputImage = document.querySelector("input[name='image']");
    const imageShow = inputImage.parentElement.querySelector("img");    
    removeAvatar.onclick = function (){
        console.log(inputImage);
        
    }
}
