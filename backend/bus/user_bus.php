<?php
require_once(__DIR__ . "/../dao/user_dao.php");
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/user_model.php");

class UserBUS implements BUSInterface
{
    private $userList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserBUS();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels()
    {
        return $this->userList;
    }

    public function refreshData(): void
    {
        $this->userList = UserDAO::getInstance()->readDatabase();
    }

    public function getModelById(int $id)
    {
        if (isset($this->userList[$id])) {
            return $this->userList[$id];
        } else {
            throw new InvalidArgumentException('Invalid user id');
        }
    }

    private function validateUser($user)
    {
        if (empty($user->getUserName()) || empty($user->getPassword()) || empty($user->getEmail()) || empty($user->getName()) || empty($user->getAddress())) {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }

    public function addModel($user)
    {
        $this->validateUser($user);
        $newUser = UserDAO::getInstance()->insert($user);
        if ($newUser) {
            $this->userList[] = $newUser;
            return true;
        }
        return false;
    }

    public function updateModel($user)
    {
        $result = UserDAO::getInstance()->update($user);
        if ($result) {
            $this->userList[$user->getId()] = $user;
            return $user->getId();
        }
        return -1;
    }

    public function deleteModel(int $id)
    {
        $user = $this->getModelById($id);
        $result = UserDAO::getInstance()->delete($id);
        if ($result) {
            $userId = $user['id'];
            unset($this->userList[$userId]);
        } else {
            throw new InvalidArgumentException('Invalid user id');
        }
        return $result;
    }

    public function searchModel(string $value, array $columns)
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Invalid search value");
        }

        if (empty($columns)) {
            $columns = array('username', 'email', 'name', 'address', 'phone', 'gender', 'role_id', 'status', 'id');
        }
        $result = UserDAO::getInstance()->search($value, $columns);
        return $result;
    }
}
