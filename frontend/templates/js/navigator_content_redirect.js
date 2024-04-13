$(document).ready(function () {
    $('.overlay__box form').on('submit', function (e) {
        e.preventDefault();

        var actionUrl = $(this).attr('action');
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: formData,
            success: function (data) {
                // handle response data
                console.log("button clicked");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // handle error
                console.error('Error:', errorThrown);
            }
        });
    });
});