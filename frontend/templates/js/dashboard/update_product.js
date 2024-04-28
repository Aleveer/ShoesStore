$(document).ready(function () {
    let productName = document.getElementById("inputEditProductName");
    let chosenCategory = document.getElementById("inputEditProductCate");
    let productPrice = document.getElementById("inputEditPrice");
    let chosenGender = document.getElementById("inputEditGender");
    let productDescription = document.getElementById("w3Editreview");
    let productImageUpload = document.getElementById("inputEditImg");
    let imageProductReview = document.getElementById("imgEditPreview");

    //Get default values:
    let productNameDefault = productName.value;
    let productPriceDefault = productPrice.value;
    let productDescriptionDefault = productDescription.value;
    let imageProductReviewDefault = imageProductReview.src;
    let chosenCategoryDefault = chosenCategory.value;
    let chosenGenderDefault = chosenGender.value;

    productImageUpload.addEventListener('change', (event) => {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let base64Image = e.target.result
                imageProductReview.src = base64Image;
            }
            reader.readAsDataURL(file);
        }
    });

    let updateBtn = document.getElementById("updateEditBtn");
    if (updateBtn) {
        updateBtn.addEventListener("click", (event) => {
            event.preventDefault();

            if (productName.value === productNameDefault &&
                productPrice.value === productPriceDefault &&
                productDescription.value === productDescriptionDefault &&
                imageProductReview.src === imageProductReviewDefault &&
                chosenCategory.value === chosenCategoryDefault &&
                chosenGender.value === chosenGenderDefault) {
                alert("No changes have been made.");
                return;
            }

            //If any changes appear: check if all fields are filled and valid:
            if (!productName.value) {
                alert("Please enter product name");
                return;
            }

            if (!productPrice.value) {
                alert("Please enter product price");
                return;
            }

            if (isNaN(productPrice.value) || productPrice.value < 0) {
                alert("Please enter a valid price");
                return;
            }

            //Check description:
            if (!productDescription.value) {
                alert("Please enter product description");
                return;
            }

            //Check valid description:
            let trimmedDescription = productDescription.value.trim();
            if (trimmedDescription.length < 10) {
                alert("Please enter a valid description");
                return;
            }

            // Check if an image has been selected
            if (productImageUpload.files.length === 0) {
                //Get default image:
                imageProductReview.value = imageProductReview.defaultValue;
            }

            $.ajax({
                url: window.location.href,
                method: "POST",
                dataType: "html",
                data: {
                    productNameEdit: productName.value,
                    categoryEdit: chosenCategory.value,
                    priceEdit: productPrice.value,
                    genderEdit: chosenGender.value,
                    descriptionEdit: productDescription.value,
                    imageEdit: imageProductReview.src,
                    updateEditBtnName: true,
                },
                success: function () {
                    alert("Product updated successfully");
                    //Once the product has been updated, go back to the dashboard:
                    window.location.href = "http://localhost/frontend/index.php?module=dashboard&view=product.view";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error updating product: " + errorThrown);
                }
            });
        });
    }

    cancelEditBtn = document.getElementById("cancelEditBtn");
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener("click", (event) => {
            event.preventDefault();
            window.location.href = "http://localhost/frontend/index.php?module=dashboard&view=product.view";
        });
    }
});