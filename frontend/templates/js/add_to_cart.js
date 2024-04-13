$(document).ready(function () {
    var sizeId = null; // Variable to store selected size ID

    // Event delegation for dynamically generated elements
    $(".psize").on("click", ".squish-in", function () {
        console.log("size clicked");
        $(".squish-in").css("color", "");
        $(this).css("color", "black");
        sizeId = $(this).text(); // Retrieving size ID from button text
    });

    var addtoCartButton = $(".addtocart");
    if (addtoCartButton.length) {
        addtoCartButton.on("click", function () {
            var quantity = $('[name="pquantity"]').val(); // Retrieving quantity
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get("id");

            if (!sizeId) {
                alert("Vui lòng chọn size");
                return;
            }

            if (!quantity) {
                alert("Vui lòng nhập số lượng");
                return;
            }

            if (isNaN(quantity)) {
                alert("Vui lòng nhập số lượng là số");
                return;
            }

            if (quantity < 1) {
                alert("Vui lòng nhập số lượng lớn hơn 0");
                return;
            }

            // Sending data via AJAX
            $.ajax({
                url:
                    "http://localhost/frontend/index.php?module=indexphp&action=singleproduct&id=" +
                    id,
                type: "POST",
                dataType: "html",
                data: {
                    addtocart: true,
                    sizeItem: sizeId,
                    pquantity: quantity, 
                },

                success: function (response) {
                    console.log("Thêm sản phẩm vào giỏ hàng thành công");
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    alert("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng");
                },
            });
        });
    }
});
