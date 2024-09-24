window.onload = function(){
    function start(){
    
        handleSeo();
        console.log( createSlug("Bóng đá"));
    }
    start();        
    function createSlug(text) {
        const from = "àáảãạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệìíỉĩịòóỏõọôồốổỗộơờớởỡợùúủũụưừứửữựỳýỷỹỵđ";
        const to   = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";
    
        // Chuyển đổi chuỗi thành chữ thường
        let slug = text.toString().toLowerCase();
    
        // Thay thế các ký tự có dấu thành ký tự không dấu tương ứng
        for (let i = 0; i < from.length; i++) {
            slug = slug.replace(new RegExp(from[i], 'g'), to[i]);
        }
    
        // Loại bỏ các ký tự không phải chữ cái, số, khoảng trắng và dấu gạch ngang
        slug = slug.replace(/[^a-z0-9\s-]/g, '');
    
        // Loại bỏ khoảng trắng ở đầu và cuối
        slug = slug.trim();
    
        // Thay thế khoảng trắng bằng dấu gạch ngang
        slug = slug.replace(/\s+/g, '-');
    
        // Loại bỏ các dấu gạch ngang thừa (nếu có)
        slug = slug.replace(/-+/g, '-');
    
        return slug;
    }
    function handleSeo(){
        const form = document.querySelector(".form-seo");
        if(form){
            // Meta_description
            function metaDesciption(){
                const widthParent = document.querySelector(".description-meta").offsetWidth;
                const text = document.querySelector("textarea[name='meta_description']");
                const meta  = document.querySelector("#meta-info");
                const seo_description = form.querySelector(".seo_description");
                if(text.value.trim() != ""){
                    const length = text.value.length;
                    seo_description.innerHTML = text.value
                    let color = "";
                    console.log(length);
                    if(length < 120 || length> 180){
                        color = "red";
                    }
                    else if(length >= 150 && length <=160){
                        color = "green";
                    }
                    else if(length >160 || length <180){
                        color = "yellow";
                    }
                    meta.style.backgroundColor = color
                    let width = Math.round((widthParent / 160) * length)
                    if(width > widthParent){
                        width = widthParent
                    }
                    meta.style.width = `${width}px`;   
                }
                text.oninput = function(){
                     const length = event.target.value.length;
                     let color = "";
                     seo_description.innerHTML = text.value
                 
                     if(length < 120 || length> 180){
                         color = "red";
                     }
                     else if(length >= 150 && length <=160){
                         color = "green";
                     }
                     else if(length >160 || length <180){
                         color = "yellow";
                     }
                     meta.style.backgroundColor = color
                     let width = Math.round((widthParent / 160) * length)
                     if(width > widthParent){
                         width = widthParent
                     }
                     meta.style.width = `${width}px`;   
         
                }
            }
            metaDesciption();
            // Meta_description
            // Title -> slug
            function titleMakeSlug(){
                var baseUrl = location.protocol + location.host;    
                const form = document.querySelector(".form-seo");
                if(form){
                    let title ;
                    if(form.querySelector("input[name='name']")){
                        title = form.querySelector("input[name='name']");
                    }
                    else {
                        title = form.querySelector("input[name='title']");
                    }
                    const slugInput = form.querySelector("input[name='slug']");
                    const showUrl = form.querySelector(".seo_url");
                    const seo_title = form.querySelector(".seo_title"); 
                    if(title.value.trim !=""){
                        const value = title.value;
                        const slug = createSlug(value);
                        slugInput.value = slug;
                        seo_title.innerHTML = value;
                        showUrl.innerHTML =  baseUrl.trim() + "/" + slug
                    }
                    title.onchange = function(){
                        const value = this.value;
                        const slug = createSlug(value);
                        slugInput.value = slug;
                        seo_title.innerHTML = value;
                        showUrl.innerHTML =  baseUrl.trim() + "/" + slug
                    }
                }
            }
            titleMakeSlug()
           
        }
    }
}

