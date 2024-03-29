<?php
require_once(__DIR__ . "/../interfaces/bus_interface.php");
require_once(__DIR__ . "/../models/orders_model.php");
require_once(__DIR__ . "/../dao/orders_dao.php");
class OrdersBUS implements BUSInterface
{
    private $ordersList = array();
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new OrdersBUS();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->refreshData();
    }
    public function getAllModels(): array
    {
        return $this->ordersList;
    }
    public function refreshData(): void
    {
        $this->ordersList = OrdersDAO::getInstance()->getAll();
    }
    public function getModelById(int $id)
    {
        return OrdersDAO::getInstance()->getById($id);
    }
    public function addModel($ordersModel): int
    {
        $this->validateModel($ordersModel);
        $result = OrdersDAO::getInstance()->insert($ordersModel);
        if ($result) {
            $this->ordersList[] = $ordersModel;
            $this->refreshData();
        }
        return $result;
    }
    public function updateModel($ordersModel): int
    {
        $this->validateModel($ordersModel);
        $result = OrdersDAO::getInstance()->update($ordersModel);
        if ($result) {
            $index = array_search($ordersModel, $this->ordersList);
            $this->ordersList[$index] = $ordersModel;
            $this->refreshData();
        }
        return $result;
    }

    public function deleteModel($ordersModel): int
    {
        $result = OrdersDAO::getInstance()->delete($ordersModel);
        if ($result) {
            $index = array_search($ordersModel, $this->ordersList);
            unset($this->ordersList[$index]);
            $this->refreshData();
        }
        return $result;
    }

    public function validateModel($ordersModel)
    {
        if (
            empty($ordersModel->getUserId()) ||
            empty($ordersModel->getTotal()) ||
            empty($ordersModel->getPaymentMethod()) ||
            empty($ordersModel->getPaymentStatus()) ||
            empty($ordersModel->getOrderStatus()) ||
            $ordersModel->getUserId() == null ||
            $ordersModel->getTotal() == null ||
            $ordersModel->getPaymentMethod() == null ||
            $ordersModel->getPaymentStatus() == null ||
            $ordersModel->getOrderStatus() == null
        ) {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }
    public function getOrdersByUserId($userId)
    {
        $ordersByUserId = array();
        foreach ($this->ordersList as $orders) {
            if ($orders->getUserId() == $userId) {
                array_push($ordersByUserId, $orders);
            }
        }
        return $ordersByUserId;
    }
    public function getOrdersByPaymentStatus($paymentStatus)
    {
        $ordersByPaymentStatus = array();
        foreach ($this->ordersList as $orders) {
            if ($orders->getPaymentStatus() == $paymentStatus) {
                array_push($ordersByPaymentStatus, $orders);
            }
        }
    }

    public function searchModel(string $value, array $columns)
    {
        return OrdersDAO::getInstance()->search($value, $columns);
    }
}
