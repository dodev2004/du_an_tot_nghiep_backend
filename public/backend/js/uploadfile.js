window.onload = function(){
    const uploadfile = document.querySelector('#upload-file');
    const show = document.querySelector(".show-image");
    uploadfile.addEventListener("change",handleUploadFile)
    function handleUploadFile(){
        const fileImages = [];
        let fileList = Array.from(this.files);
        fileList.forEach((filename,index) => {
            if(validateImageFile(filename.name.trim())){
                console.log(fileList);
                fileImages.push(fileList[index])
            }
                
        });
        
    if(fileImages.length > 0){
        const fileSrc = [];
        const img = document.createElement('img');
        show.classList.add("active");
        show.innerHTML = ""
        img.classList.add("show_image")
        img.style.width = "100px";
        img.style.height = "100px";
        fileImages.forEach(file =>{ 
            img.src = URL.createObjectURL(file);
            show.appendChild(img);
        })
       
    }
    else {
        uploadfile.value = "";
        console.log(uploadfile.value);
    }
       
    }
    function validateImageFile(filename){
        const regexFile =/^[a-zA-Z0-9_\-\s\(\)]+\.(jpg|jpeg|png)$/i;
        return regexFile.test(filename)
    }
}