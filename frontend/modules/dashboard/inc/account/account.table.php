<table class="table align-middle table-borderless table-hover text-start">
    <thead>
        <tr class="align-middle">
            <th>Img</th>
            <th>Username</th>
            <th>Password</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Role</th>
            <th>Status</th>
            <th>Manage</th>

        </tr>
    </thead>
    <?php foreach ($userListDetail as $user) : ?>
        <tbody>
            <tr>
                <td class='col-1'><img
                        src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg"
                        alt=""></td>
                <td class='col-1'><?= $user->getUsername() ?></td>
                <td class='col-1'><?= $user->getPassword() ?></td>
                <td class='col-2'><?= $user->getName() ?></td>
                <td class='col-1'><?= $user->getEmail() ?></td>
                <td class='col-1'><?= $user->getPhone() ?></td>
                <td class="col-2"><?= $user->getAddress() ?></td>
                <td class='col-1'><?= $user->getRoleId() ?></td>
                <td class='col-1'><?= $user->getStatus() ?></td>
                <td class='col-2 userAction'>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
                        <span data-feather="lock"></span>
                        Lock
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <span data-feather="trash-2"></span>
                        Delete
                    </button>
                </td>

            </tr>
        </tbody>
    <?php endforeach; ?>
</table>