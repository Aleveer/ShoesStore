<?php
require_once(__DIR__ . "/../dao/database_connection.php");
require_once(__DIR__ . "/../dao/user_dao.php");
require_once(__DIR__ . "/../models/user_model.php");

use PHPUnit\Framework\TestCase;

class UserDAOTest extends TestCase
{
    private $userDAO;

    protected function setUp(): void
    {
        $this->userDAO = UserDAO::getInstance();
    }

    public function testReadDatabase()
    {
        $userList = $this->userDAO->readDatabase();
        $this->assertIsArray($userList);
        $this->assertNotEmpty($userList);
        // Add more assertions to validate the data returned from the database
    }

    public function testGetAll()
    {
        $userList = $this->userDAO->getAll();
        $this->assertIsArray($userList);
        $this->assertNotEmpty($userList);
        // Add more assertions to validate the data returned from the database
    }

    public function testGetById()
    {
        $user = $this->userDAO->getById(1);
        $this->assertInstanceOf(UserModel::class, $user);
        // Add more assertions to validate the user object
    }

    public function testInsert()
    {
        $newUser = new UserModel(null, "john_doe", "password123", "john@example.com", "John Doe", "1234567890", "Male", "avatar.jpg", 1, "Active", "123 Main St");
        $userId = $this->userDAO->insert($newUser);
        $this->assertIsInt($userId);
        $this->assertGreaterThan(0, $userId);
        // Add more assertions to validate the insertion
    }

    public function testUpdate()
    {
        $userToUpdate = $this->userDAO->getById(1);
        if ($userToUpdate) {
            $userToUpdate->setName("Updated Name");
            $affectedRows = $this->userDAO->update($userToUpdate);
            $this->assertIsInt($affectedRows);
            $this->assertGreaterThan(0, $affectedRows);
            // Add more assertions to validate the update
        } else {
            $this->fail("User not found");
        }
    }

    public function testDelete()
    {
        $userId = 1;
        $affectedRows = $this->userDAO->delete($userId);
        $this->assertIsInt($affectedRows);
        $this->assertGreaterThan(0, $affectedRows);
        // Add more assertions to validate the deletion
    }

    public function testSearch()
    {
        $searchCondition = "john";
        $userList = $this->userDAO->search($searchCondition, ["username", "name", "email"]);
        $this->assertIsArray($userList);
        $this->assertNotEmpty($userList);
        // Add more assertions to validate the search results
    }
}
