<?php
require_once 'backend/dao/user_dao.php';
require_once 'backend/bus/bus_interface.php';
require_once 'backend/model/user_model.php';
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
        $this->userList = UserDAO::getInstance()->readDatabase();
    }

    public function getAllModels()
    {
        $this->userList = UserDAO::getInstance()->readDatabase();
    }

    public function refreshData(): void
    {
        $this->userList = [];
        $this->userList = UserDAO::getInstance()->readDatabase();
    }

    public function getModelById(int $id)
    {
        foreach ($this->userList as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }
        return null;
    }

    public function addModel($user)
    {
    }
}
