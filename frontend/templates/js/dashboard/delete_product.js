$(document).ready(function () {
    let deleteButton = document.querySelectorAll('[name="deleteProductButton"]');
    deleteButton.forEach(function (button, index) {
        button.addEventListener('click', function () {
            console.log('delete button clicked');
            let productId = $(this).closest('tr').children('td:nth-child(2)').text();
            let status = $(this).closest('tr').children('td:last-child').text();

            if (status === 'inactive') {
                alert('Product is already hidden');
                return;
            }

            $.ajax({
                url: window.location.href,
                method: 'POST',
                dataType: 'json',
                data: {
                    productId: productId,
                    deleteButton: true,
                },
                success: function (data) {
                    if (data.status == "success") {
                        alert(data.message);
                    } else if (data.status == "error") {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Delete request failed');
                    // Handle the error response here
                }
            });
        });
    });

    let completelyDelButton = document.querySelectorAll('[name="completelyDeleteProduct"]');
    completelyDelButton.forEach(function (button, index) {
        button.addEventListener('click', function () {
            let productId = $(this).closest('tr').children('td:nth-child(2)').text();
            if (confirm('Product will be deleted permanently. This action cannot be undone. Proceed with caution! Proceed?')) {
                // Proceed with the delete operation
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        productId: productId,
                        completelyDeleteProduct: true,
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            alert(data.message);
                            //refresh page
                            window.location.reload();
                        } else if (data.status == "error") {
                            alert(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Completely delete request failed');
                        // Handle the error response here
                    }
                });
            } else {
                // Cancel the delete operation
            }

        });
    });
});