$(document).ready(function () {
    let deleteBtn = document.querySelectorAll('[name="deleteSizeBtn"]');
    deleteBtn.forEach(function (button, index) {
        button.addEventListener('click', function () {
            console.log('delete button clicked');
            let sizeId = $(this).closest('tr').find('td:first').text();
            $.ajax({
                url: 'http://localhost/frontend/index.php?module=dashboard&view=size.view',
                method: 'POST',
                dataType: 'html',
                data: {
                    sizeId: sizeId,
                    deleteSizeBtn: true,
                },
                success: function () {
                    window.location.reload();
                },
                error: function (xhr, status, error) {
                    console.log('Delete request failed');
                    // Handle the error response here
                }
            });
        });
    });
});