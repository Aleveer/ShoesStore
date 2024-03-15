<?php
require_once(__DIR__ . "/../dao/database_connection.php");
require_once(__DIR__ . "/../models/payment_method_model.php");
require_once(__DIR__ . "/../interfaces/dao_interface.php");

class PaymentMethodsBUS implements BUSInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PaymentMethodsBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return PaymentMethodsDAO::getInstance()->getAll();
    }

    public function refreshData(): void
    {
        PaymentMethodsDAO::getInstance()->readDatabase();
    }

    public function getModelById(int $id)
    {
        return PaymentMethodsDAO::getInstance()->getById($id);
    }

    public function addModel($paymentMethodModel): int
    {
        $this->validateModel($paymentMethodModel);
        $result = PaymentMethodsDAO::getInstance()->insert($paymentMethodModel);
        $this->refreshData();
        return $result;
    }

    public function updateModel($paymentMethodModel): int
    {
        $this->validateModel($paymentMethodModel);
        $result = PaymentMethodsDAO::getInstance()->update($paymentMethodModel);
        $this->refreshData();
        return $result;
    }

    public function deleteModel($paymentMethodModel): int
    {
        $result = PaymentMethodsDAO::getInstance()->delete($paymentMethodModel);
        $this->refreshData();
        return $result;
    }

    public function searchModel(string $value, array $columns)
    {
        return PaymentMethodsDAO::getInstance()->search($value, $columns);
    }

    private function validateModel($paymentMethodModel)
    {
        if ($paymentMethodModel->getName() == null || $paymentMethodModel->getName() == "") {
            throw new Exception("Name cannot be empty");
        }
    }
}
