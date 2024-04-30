$(document).ready(function () {
    let username = document.getElementById("inputEditAccountUsername");
    let password = document.getElementById("inputEditAccountPassword");
    let name = document.getElementById("inputEditAccountName");
    let email = document.getElementById("inputEditAccountEmail");
    let phone = document.getElementById("inputEditAccountPhone");
    let gender = document.getElementById("inputEditGender");
    let status = document.getElementById("inputEditStatus");
    let address = document.getElementById("inputEditAddress");
    let role = document.getElementById("inputEditAccountRole");
    let imageUpload = document.getElementById("inputEditImg");
    let imageReview = document.getElementById("imageEdit");

    // Get default values:
    let usernameDefault = username.value;
    let passwordDefault = password.value;
    let nameDefault = name.value;
    let emailDefault = email.value;
    let phoneDefault = phone.value;
    let genderDefault = gender.value;
    let statusDefault = status.value;
    let addressDefault = address.value;
    let roleDefault = role.value;
    let imageReviewDefault = imageReview.src;

    imageUpload.addEventListener('change', (event) => {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let base64Image = e.target.result
                imageReview.src = base64Image;
            }
            reader.readAsDataURL(file);
        }
    });

    let updateBtn = document.getElementById("updateEditBtn");
    if (updateBtn) {
        updateBtn.addEventListener("click", (event) => {
            event.preventDefault();

            if (username.value === usernameDefault &&
                password.value === passwordDefault &&
                name.value === nameDefault &&
                email.value === emailDefault &&
                phone.value === phoneDefault &&
                gender.value === genderDefault &&
                status.value === statusDefault &&
                address.value === addressDefault &&
                role.value === roleDefault &&
                imageReview.src === imageReviewDefault) {
                alert("No changes have been made.");
                return;
            }

            // If any changes appear: check if all fields are filled and valid:
            if (!username.value) {
                alert("Please enter username");
                return;
            }

            if (!password.value) {
                alert("Please enter password");
                return;
            }

            if (!name.value) {
                alert("Please enter name");
                return;
            }

            if (!email.value) {
                alert("Please enter email");
                return;
            }

            if (!phone.value) {
                alert("Please enter phone");
                return;
            }

            if (!address.value) {
                alert("Please enter address");
                return;
            }

            // Check if an image has been selected
            if (imageUpload.files.length === 0) {
                // Get default image:
                imageReview.value = imageReview.defaultValue;
            }

            $.ajax({
                url: window.location.href,
                method: "POST",
                dataType: "html",
                data: {
                    usernameEdit: username.value,
                    passwordEdit: password.value,
                    nameEdit: name.value,
                    emailEdit: email.value,
                    phoneEdit: phone.value,
                    genderEdit: gender.value,
                    statusEdit: status.value,
                    addressEdit: address.value,
                    roleEdit: role.value,
                    imageEdit: imageReview.src,
                    updateEditBtnName: true,
                },
                success: function () {
                    alert("Account updated successfully");
                    // Once the account has been updated, go back to the dashboard:
                    window.location.href = "http://localhost/frontend/index.php?module=dashboard&view=account.view";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error updating account: " + errorThrown);
                }
            });
        });
    }

    let cancelEditBtn = document.getElementById("cancelEditBtn");
    if (cancelEditBtn) {
        cancelEditBtn.addEventListener("click", (event) => {
            event.preventDefault();
            window.location.href = "http://localhost/frontend/index.php?module=dashboard&view=account.view";
        });
    }
});