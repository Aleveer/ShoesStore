document.addEventListener('DOMContentLoaded', function () {
    // Select all card bodies
    let cardBodies = document.querySelectorAll('.card-body');

    // Iterate over card bodies
    cardBodies.forEach((cardBody) => {
        // Attach click event listener to each card body
        cardBody.addEventListener('click', (event) => {
            // Handle the event here
            console.log('Card body clicked:', event.target);
        });
    });

    // Select the reset button inside the first card
    let firstCard = document.querySelector('.card-body');
    let resetButton = firstCard.querySelector('#resetButton');

    // Attach click event listener to the reset button
    resetButton.addEventListener('click', (event) => {
        // Get the input fields and checkboxes
        let username = document.getElementById('usernameId');
        let name = document.getElementById('accountNameId');
        let email = document.getElementById('mailAccountId');
        let maleGender = document.getElementById('male');
        let femaleGender = document.getElementById('female');

        // Check for any of these changes then reset, if it remains the same, do nothing:
        if (username.value !== username.defaultValue ||
            name.value !== name.defaultValue ||
            email.value !== email.defaultValue ||
            maleGender.checked !== maleGender.defaultChecked ||
            femaleGender.checked !== femaleGender.defaultChecked) {

            // Reset the input fields and checkboxes to their original values
            username.value = username.defaultValue;
            name.value = name.defaultValue;
            email.value = email.defaultValue;
            maleGender.checked = maleGender.defaultChecked;
            femaleGender.checked = femaleGender.defaultChecked;
        }

        // Use ajax to send the data only if there is a change:
        $.ajax({
            url: "http://localhost/frontend/index.php?module=accountsetting&action=profilesetting",
            type: "POST",
            dataType: "html",
            data: {
                username: username.value,
                name: name.value,
                email: email.value,
                maleGender: maleGender.checked,
                femaleGender: femaleGender.checked,
            },
            success: function (data) {
                console.log("sent successfully");
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

    // Select the save button inside the first card
    //let saveButton = firstCard.querySelector('#applyChangesFirstCard');
    let saveButton = document.getElementById('applyChangesFirstCard');
    if (saveButton) {
        saveButton.addEventListener('click', (event) => {
            let username = document.getElementById('usernameId');
            let name = document.getElementById('accountNameId');
            let email = document.getElementById('mailAccountId');
            let maleGender = document.getElementById('male');
            let femaleGender = document.getElementById('female');

            if (username.value !== username.defaultValue ||
                name.value !== name.defaultValue ||
                email.value !== email.defaultValue ||
                maleGender.checked !== maleGender.defaultChecked ||
                femaleGender.checked !== femaleGender.defaultChecked) {
                // Use ajax to send the data only if there is a change:
                $.ajax({
                    url: "http://localhost/frontend/index.php?module=accountsetting&action=profilesetting",
                    type: "POST",
                    dataType: "html",
                    data: {
                        username: username.value,
                        'account-name': name.value,
                        mailAccount: email.value,
                        maleGender: maleGender.checked,
                        femaleGender: femaleGender.checked,
                        saveButton: true,
                    },
                });
            }
        });
    }

    // Select the reset button inside the second card
    let changePasswordButton = document.getElementById('applyChangesSecondCard');
    if (changePasswordButton) {
        // Attach click event listener to the save button
        changePasswordButton.addEventListener('click', (event) => {
            // Get the input fields and checkboxes
            let currentPassword = document.getElementById('currentPassword');
            let newPassword = document.getElementById('newPassword');
            let confirmNewPassword = document.getElementById('repeatNewPassword');

            //Check for empty current password field:
            if (currentPassword.value === "") {
                alert("Please enter your current password!");
                return;
            }

            //Check for empty new password field:
            if (newPassword.value === "") {
                alert("Please enter your new password!");
                return;
            }

            //Check for empty confirm new password field:
            if (confirmNewPassword.value === "") {
                alert("Please confirm your new password!");
                return;
            }

            //Check if new password and confirm new password match:
            if (newPassword.value !== confirmNewPassword.value) {
                alert("New password and confirm new password do not match!");
                return;
            }

            //Check for changes then use ajax to send the changed data:
            if (currentPassword.value !== currentPassword.defaultValue ||
                newPassword.value !== newPassword.defaultValue ||
                confirmPassword.value !== confirmPassword.defaultValue) {
                // Use ajax to send the data only if there is a change:
                $.ajax({
                    url: "http://localhost/frontend/index.php?module=accountsetting&action=profilesetting",
                    type: "POST",
                    dataType: "html",
                    data: {
                        currentPassword: currentPassword.value,
                        newPassword: newPassword.value,
                        repeatNewPassword: confirmNewPassword.value,
                        saveButtonPassword: true,
                    },
                });
            }
        });
    }

    let changeContactButton = document.getElementById('applyChangesThirdCard');
    if (changeContactButton) {
        // Attach click event listener to the save button
        changeContactButton.addEventListener('click', (event) => {
            // Get the input fields and checkboxes
            let phoneNumber = document.getElementById('phoneField');
            let address = document.getElementById('addressField');

            //Check for empty phone number field:
            if (phoneNumber.value === "") {
                alert("Please enter your phone number!");
                return;
            }

            //Check for empty address field:
            if (address.value === "") {
                alert("Please enter your address!");
                return;
            }

            $.ajax({
                url: "http://localhost/frontend/index.php?module=accountsetting&action=profilesetting",
                type: "POST",
                dataType: "html",
                data: {
                    'phone-customer': phoneNumber.value,
                    'address-customer': address.value,
                    saveContactButton: true,
                },
            });

        });
    }
    // document.addEventListener('DOMContentLoaded', (event) => {
    //     //Image upload handling:
    //     let imageUploadBtn = document.querySelector('#imageUploadIdButton');
    //     let imageUploadLabel = document.querySelector('label.btn.btn-outline-primary');
    //     if (imageUploadBtn && imageUploadLabel) {
    //         imageUploadLabel.addEventListener('click', (event) => {
    //             imageUploadBtn.addEventListener('change', (event) => {
    //                 console.log('Image upload button clicked:', event.target);
    //                 // Get the image file
    //                 let imageFile = event.target.files[0];
    //                 let formData = new FormData();
    //                 formData.append('image', imageFile);

    //                 // Use ajax to send the data only if there is a change:
    //                 $.ajax({
    //                     url: "http://localhost/frontend/index.php?module=accountsetting&action=profilesetting",
    //                     type: "POST",
    //                     dataType: "html",
    //                     data: formData,
    //                     processData: false,
    //                     contentType: false,
    //                     success: function (data) {
    //                         console.log("sent successfully");
    //                         if (data.status == "success") {
    //                             alert(data.message);
    //                         } else if (data.status == "error") {
    //                             alert(data.message);
    //                         }
    //                     },
    //                     error: function (xhr, status, error) {
    //                         console.error("Error:", error);
    //                         alert("Error occurred. Please try again.");
    //                     },
    //                 });
    //             });
    //         });
    //     } else {
    //         console.error('Image upload button or label not found');
    //     }
    // });
});
