// order_processing.js
$(document).ready(function () {
    $('#order-confirm-submit').click(function (e) {
        e.preventDefault();
        var submitOrderButton = $('#order-confirm-submit');
        if (submitOrderButton.length) {
            submitOrderButton.on('click', function () {
                var inputName = $('#inputNameId').val();
                var inputPhoneNumber = $('#inputPhoneNumberId').val();
                var inputAddress = $('#inputAddressId').val();
                var inputDiscount = $('#inputDiscountId').val();
                if (!inputName) {
                    alert('Vui lòng nhập tên');
                    return;
                }

                if (!inputPhoneNumber) {
                    alert('Vui lòng nhập số điện thoại');
                    return;
                }
                if (!inputAddress) {
                    alert('Vui lòng nhập địa chỉ');
                    return;
                }

                if (isNaN(inputPhoneNumber)) {
                    alert('Vui lòng nhập số điện thoại là số');
                    return;
                }

                $.ajax({
                    url: '?module=cartsection&action=order',
                    type: 'POST',
                    data: {
                        submitOrderButton: true,
                        inputName: inputName,
                        inputPhoneNumber: inputPhoneNumber,
                        inputAddress: inputAddress,
                        inputDiscount: inputDiscount
                    },
                    success: function (response) {
                        // Handle the response from the server
                        console.log('the button is clicked');
                        alert('Đặt hàng thành công');
                    },
                    error: function (error) {
                        // Handle any errors
                    },
                });
            });
        }


        // Function to update the total price when applying discount
        function updateTotalPrice(discount) {
            $.ajax({
                url: '?module=cartsection&action=order',
                type: 'POST',
                data: {
                    discount: discount
                },
                success: function (discountedPrice) {
                    var formattedPrice = discountedPrice.toLocaleString('en-US');
                    $("#totalPrice").html('Total: ' + formattedPrice + ' VND');
                },
                error: function (error) {
                    // Handle any errors
                }
            });
        }
    });
});