<script>
    $(document).on('click', '.product', function() {
    // Lấy thông tin sản phẩm từ thuộc tính data
    var productName = $(this).data('name');
    var productDescription = $(this).data('description');
    var productPrice = $(this).data('price');
    var productDiscountPrice = $(this).data('discount-price');
    var productStock = $(this).data('stock');
    var productWeight = $(this).data('weight');
    var productRatingsAvg = $(this).data('ratings-avg');
    var productRatingsCount = $(this).data('ratings-count');
    var productStatus = $(this).data('status');
    var productImage = $(this).data('image-url');

    // Cập nhật thông tin vào modal
    $('#productName').text(productName ? productName : 'Dữ liệu chưa có');
    $('#productDescription').text(productDescription ? productDescription : 'Dữ liệu chưa có');
    $('#productPrice').text(productPrice ? productPrice : 'Dữ liệu chưa có');
    $('#productDiscountPrice').text(productDiscountPrice ? productDiscountPrice : 'Dữ liệu chưa có');
    $('#productStock').text(productStock ? productStock : 'Dữ liệu chưa có');
    $('#productWeight').text(productWeight ? productWeight : 'Dữ liệu chưa có');
    $('#productRatingsAvg').text(productRatingsAvg ? productRatingsAvg : 'Dữ liệu chưa có');
    $('#productRatingsCount').text(productRatingsCount ? productRatingsCount : 'Dữ liệu chưa có');
    $('#productStatus').text(productStatus ? productStatus : 'Dữ liệu chưa có');
    $('#productImage').attr('src', productImage);

    // Mở modal
    $('#productDetailModal').modal('show');
});

</script>