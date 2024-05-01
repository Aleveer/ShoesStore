$(document).ready(function () {
    var sizeId = null; // Variable to store selected size ID

    // Event delegation for dynamically generated elements
    $(".psize").on("click", ".squish-in", function () {
        console.log("size clicked");
        $(".squish-in").css("color", "");
        $(this).css("color", "black");
        sizeId = $(this).attr('id').split('_')[1]; // Retrieving size ID from button ID
    });

    var addToCartButton = $(".addToCart");
    if (addToCartButton.length) {
        addToCartButton.on("click", function () {
            console.log("add to cart clicked");
            var quantity = $('[name="pquantity"]').val(); // Retrieving quantity
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get("id");

            if (!sizeId) {
                alert("Please select a size");
                return;
            }

            if (!quantity) {
                alert("Please enter quantity");
                return;
            }

            if (isNaN(quantity)) {
                alert("Please enter a valid quantity");
                return;
            }

            if (quantity < 1) {
                alert("Quantity should be greater than 0");
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
                    addToCart: true,
                    sizeItem: sizeId,
                    pquantity: quantity,
                },

                success: function (data) {
                    if (data.status == "success") {
                        alert(data.message);
                    } else if (data.status == "error") {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    alert("Error occurred. Please try again.");
                },
            });
        });
    }
});
