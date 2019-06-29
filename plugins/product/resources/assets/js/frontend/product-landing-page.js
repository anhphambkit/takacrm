$(document).on('change', '#product-quantity', function (e) {
    e.preventDefault();
    let quantity = $(this).val();
    if (quantity <= 0)
        $(this).val(1);

    let onlinePrice = parseInt($('.online-price').html());
    let onlineDiscount = parseFloat($('.online-discount').html());
    let total = "Contact";
    if (onlinePrice)
        total = Math.abs($(this).val()*onlinePrice*((100-onlineDiscount)/100));
    $('.total-price-product').html(total);
    $('#total_price').html(total);
    $('#sub_total').html(total);
    $('#total_order').html(total);
});