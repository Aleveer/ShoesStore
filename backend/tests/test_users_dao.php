<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File Execution</title>
</head>

<body>
    <h1>PHP File Execution</h1>
    <?php
    require_once 'backend/interfaces/dao_interface.php';
    require_once 'backend/models/user_model.php';
    require_once 'backend/dao/database_connection.php';
    require_once 'backend/dao/users_dao.php';
    // Instantiate UserDAO
    $userDAO = UserDAO::getInstance();

    // Test readDatabase() method
    $userList = $userDAO->readDatabase();
    echo "<h2>User List:</h2>";
    foreach ($userList as $user) {
        echo "ID: " . $user->getId() . ", Username: " . $user->getUsername() . "<br>";
    }

    // Test getAll() method
    $userList = $userDAO->getAll();
    echo "<h2>User List:</h2>";
    foreach ($userList as $user) {
        echo "ID: " . $user->getId() . ", Username: " . $user->getUsername() . "<br>";
    }

    // Test getById() method
    $user = $userDAO->getById(1);
    if ($user) {
        echo "<h2>User found:</h2>";
        echo "ID: " . $user->getId() . ", Username: " . $user->getUsername() . "<br>";
    } else {
        echo "<h2>User not found</h2>";
    }

    // Test insert() method
    $newUser = new UserModel(null, "john_doe", "password123", "john@example.com", "John Doe", "1234567890", "Male", "avatar.jpg", 1, "Active", "123 Main St");
    $insertedRows = $userDAO->insert($newUser);
    echo "<h2>Inserted rows:</h2>" . $insertedRows . "<br>";

    // Test update() method
    $userToUpdate = $userDAO->getById(1);
    if ($userToUpdate) {
        $userToUpdate->setName("Updated Name");
        $updatedRows = $userDAO->update($userToUpdate);
        echo "<h2>Updated rows:</h2>" . $updatedRows . "<br>";
    } else {
        echo "<h2>User not found</h2>";
    }

    // Test delete() method
    $deletedRows = $userDAO->delete(1);
    echo "<h2>Deleted rows:</h2>" . $deletedRows . "<br>";

    // Test search() method
    $searchCondition = "john";
    $searchResults = $userDAO->search($searchCondition, ["username", "name", "email"]);
    echo "<h2>Search Results:</h2>";
    foreach ($searchResults as $user) {
        echo "ID: " . $user->getId() . ", Username: " . $user->getUsername() . "<br>";
    }
    ?>
</body>

</html>