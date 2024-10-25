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
    $('#productName').text(productName);
    $('#productDescription').text(productDescription);
    $('#productPrice').text(productPrice);
    $('#productDiscountPrice').text(productDiscountPrice);
    $('#productStock').text(productStock);
    $('#productWeight').text(productWeight);
    $('#productRatingsAvg').text(productRatingsAvg);
    $('#productRatingsCount').text(productRatingsCount);
    $('#productStatus').text(productStatus);
    $('#productImage').attr('src', productImage);

    // Mở modal
    $('#productDetailModal').modal('show');
});

</script>