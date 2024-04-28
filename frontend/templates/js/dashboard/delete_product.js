$(document).ready(function () {
    let deleteButton = document.querySelectorAll('[name="deleteProductButton"]');
    deleteButton.forEach(function (button, index) {
        button.addEventListener('click', function () {
            console.log('delete button clicked');
            let productId = $(this).closest('tr').children('td:nth-child(2)').text();
            console.log(productId);
            $.ajax({
                url: window.location.href,
                method: 'POST',
                dataType: 'html',
                data: {
                    productId: productId,
                    deleteButton: true,
                },
                success: function (response) {
                    console.log('Delete request successful');
                    alert('Product hidden successfully');
                },
                error: function (xhr, status, error) {
                    console.log('Delete request failed');
                    // Handle the error response here
                }
            });
        });
    });
});