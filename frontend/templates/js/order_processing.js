$(document).ready(function () {
    var submitOrderButton = document.getElementById('order-confirm-submit');
    if (submitOrderButton.length > 0) {
        submitOrderButton.on('click', function (e) {
            e.preventDefault();

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
                url: 'http://localhost/frontend/index.php?module=indexphp&action=order',
                type: 'POST',
                dataType: 'html',
                data: {
                    module: 'cartsection',
                    action: 'order',
                    submitOrderButton: true,
                    inputName: inputName,
                    inputPhoneNumber: inputPhoneNumber,
                    inputAddress: inputAddress,
                    inputDiscount: inputDiscount
                },
                success: function (response) {
                    // Parse the response (assuming it's JSON)
                    var data = JSON.parse(response);
                    // Check if the order was successful
                    if (data.success) {
                        alert('Đặt hàng thành công!');
                    } else {
                        alert('Đặt hàng thất bại: ' + data.message);
                    }
                },
                error: function (error) {
                    // Handle any errors
                },
            });
        });
    }
});