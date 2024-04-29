$(document).ready(function () {
    $(document).on('submit', 'form[id^="form_"]', function (e) {
        e.preventDefault();

        var formId = $(this).attr('id');
        var productId = formId.split('_')[1];
        var sizeId = formId.split('_')[2];
        var modalId = '#editQuantityModal' + productId + '_' + sizeId;
        var newQuantity = parseInt($(modalId).find('#inputNewQuantity').val(), 10);
        var currentQuantity = parseInt($(modalId).find('#inputQuantity').val(), 10);

        //Check quantity:
        if (isNaN(newQuantity)) {
            alert('Please enter a valid quantity');
            return;
        }

        if (newQuantity < 0) {
            var checkingQuantity = currentQuantity + newQuantity;
            if (checkingQuantity < 0) {
                alert('Quantity cannot be negative');
                return;
            }
        }

        $.ajax({
            url: 'http://localhost/frontend/index.php?module=dashboard&view=inventory.view',
            type: 'POST',
            data: {
                productId: productId,
                sizeId: sizeId,
                newQuantity: newQuantity,
                currentQuantity: currentQuantity,
                button: true
            },
            success: function (response) {
                // handle success
                console.log('Update successful');
                alert('Updated successfully');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // handle error
                console.log('Update failed: ' + textStatus);
            }
        });
    });
});