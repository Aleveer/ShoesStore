$(document).ready(function () {
    // Get all lock buttons
    const lockButtons = document.querySelectorAll('[id^="lockAccountBtn_"]');
    lockButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.id.replace('lockAccountBtn_', '');
            // Perform your lock operation here
            console.log(`Lock button clicked for id: ${id}`);
            //Use ajax to send the id to the server:
            $.ajax({
                type: 'POST',
                url: 'http://localhost/frontend/index.php?module=dashboard&view=account.view',
                data: {
                    'id': id,
                    lockBtn: true
                },
                success: function () {
                    console.log(`Account with id: ${id} has been locked`);
                },
                error: function () {
                    console.log(`An error occurred while locking account with id: ${id}`);
                }
            });

        });
    });

    // Get all unlock buttons
    const unlockButtons = document.querySelectorAll('[id^="unlockAccountBtn_"]');
    unlockButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.id.replace('unlockAccountBtn_', '');
            // Perform your unlock operation here
            console.log(`Unlock button clicked for id: ${id}`);
            //Use ajax to send the id to the server:
            $.ajax({
                type: 'POST',
                url: 'http://localhost/frontend/index.php?module=dashboard&view=account.view',
                data: {
                    'id': id,
                    unlockBtn: true
                },
                success: function () {
                    console.log(`Account with id: ${id} has been unlocked`);
                },
                error: function () {
                    console.log(`An error occurred while unlocking account with id: ${id}`);
                }
            });
        });
    });
});