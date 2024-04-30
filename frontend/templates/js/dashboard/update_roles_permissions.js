$(document).ready(function () {
    $(document).on('submit', 'form', function (e) {
        e.preventDefault();
        console.log('edit role form submitted');

        var roleId = $(this).closest('.modal').attr('id').replace('editRoleModal_', '');
        var roleName = $('#inputName_' + roleId);
        var permissions = [];

        // Collect all checked permissions
        $('.form-check-input:checked').each(function () {
            permissions.push($(this).val());
        });

        console.log('roleId: ' + roleId);
        console.log('roleName: ' + roleName.val());
        console.log('permissions: ' + permissions);

        function isValidInput() {
            return roleName.val();
        }

        if (!isValidInput()) {
            alert('Role name is required');
            return;
        }

        $.ajax({
            url: 'http://localhost/frontend/index.php?module=dashboard&view=role.view',
            method: 'POST',
            datatype: 'html',
            data: {
                id: roleId,
                name: roleName.val(),
                permissions: permissions,
                updateBtnName: true,
            },
            success: function (response) {
                window.location.reload();
                // if (response === 'success') {
                //     alert('Role updated successfully');
                //     location.reload();
                // }
            },
            error: function (xhr, status, error) {
                // handle any errors
                alert('An error occurred: ' + error);
            }
        });
    });
});