$(document).ready(function () {
    $(document).on('submit', '.modal-content form', function (e) {
        e.preventDefault();

        var permissionId = $(this).closest('.modal').attr('id').replace('editPermissionModal_', '');
        var permissionName = $('#inputName_' + permissionId).val();

        //Check for valid permission name
        if (permissionName === '') {
            alert('Please enter a valid permission name');
            return;
        }

        //Check for empty permission name:
        //Trim first then check if it's empty
        if (permissionName.trim() === '') {
            alert('Please enter a valid permission name');
            return;
        }

        $.ajax({
            url: 'http://localhost/frontend/index.php?module=dashboard&view=permission.view',
            type: 'POST',
            dataType: 'json',
            data: {
                id: permissionId,
                name: permissionName,
                submit: true
            },
            success: function (data) {
                if (data.status == "success") {
                    alert(data.message);
                    $('#editPermissionModal_' + permissionId).modal('hide'); // Close the modal
                } else if (data.status == "error") {
                    alert(data.message);
                }
            },
            error: function (response) {
                // Handle error - you might want to show an error message
                console.error('Failed to update permission');
            }
        });
    });
});