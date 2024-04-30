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

        $.ajax({
            url: 'http://localhost/frontend/index.php?module=dashboard&view=permission.view',
            type: 'POST',
            data: {
                id: permissionId,
                name: permissionName,
                submit: true
            },
            success: function (response) {
                // Handle success - you might want to show a success message, or update the permission name in the table
                console.log('Permission updated successfully');
                $('#editPermissionModal_' + permissionId).modal('hide'); // Close the modal
            },
            error: function (response) {
                // Handle error - you might want to show an error message
                console.error('Failed to update permission');
            }
        });
    });
});