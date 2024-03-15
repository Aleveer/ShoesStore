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
        return PaymentMethodsDAO::getInstance()->insert($paymentMethodModel);
    }

    public function updateModel($paymentMethodModel): int
    {
        $this->validateModel($paymentMethodModel);
        return PaymentMethodsDAO::getInstance()->update($paymentMethodModel);
    }

    public function deleteModel($paymentMethodModel): int
    {
        return PaymentMethodsDAO::getInstance()->delete($paymentMethodModel);
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
