<?php
class UserPermissionBUS implements BUSInterface
{
    private $userPermissionList = array();
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserPermissionBUS();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels()
    {
        return $this->userPermissionList;
    }

    public function refreshData(): void
    {
        $this->userPermissionList = UserPermissionDAO::getInstance()->readDatabase();
    }

    public function getModelById(int $id)
    {
        if (isset($this->userPermissionList[$id])) {
            return $this->userPermissionList[$id];
        } else {
            throw new InvalidArgumentException('Invalid user permission id');
        }
    }

    private function validateUserPermission($userPermission)
    {
        if (empty($userPermission->getUserId()) || empty($userPermission->getPermissionId())) {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }

    public function addModel($userPermission)
    {
        $this->validateUserPermission($userPermission);
        $newUserPermission = UserPermissionDAO::getInstance()->insert($userPermission);
        if ($newUserPermission) {
            $this->userPermissionList[] = $newUserPermission;
            return true;
        }
        return false;
    }

    public function updateModel($userPermission)
    {
        $result = UserPermissionDAO::getInstance()->update($userPermission);
        if ($result) {
            foreach ($this->userPermissionList as $key => $value) {
                if ($value->getId() == $userPermission->getId()) {
                    $this->userPermissionList[$key] = $userPermission;
                    break;
                }
            }
            return true;
        }
        return false;
    }

    public function deleteModel(int $id)
    {
        $userPermission = $this->getModelById($id);
        $result = UserPermissionDAO::getInstance()->delete($userPermission);
        if ($result) {
            $userPermissionId = $userPermission['id'];
            unset($this->userPermissionList[$userPermissionId]);
        } else {
            throw new InvalidArgumentException('Invalid user permission id');
        }
        return $result;
    }

    public function searchModel(string $value, array $columns)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Invalid search value');
        }
        if (empty($columns)) {
            $columns = array('user_id', 'permission_id', 'id', 'status');
        }

        $result = UserPermissionDAO::getInstance()->search($value, $columns);
        return $result;
    }
}
