<div class="ibox-content_top">
   
       <form action="" method="GET" class="form_seach">
        <input type="text" class="form-control" name="search_text" @if(isset($_GET["search_text"])) value="{{$_GET['search_text']}}" @endif placeholder="Tìm kiếm theo tên">
        <button class="btn btn-primary seach"> <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm </button> 
       </form>
       

</div>