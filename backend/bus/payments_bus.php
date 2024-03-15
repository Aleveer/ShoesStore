<?php
require_once(__DIR__ . "/../dao/database_connection.php");
require_once(__DIR__ . "/../models/payment_model.php");
require_once(__DIR__ . "/../interfaces/dao_interface.php");

class PaymentsBUS implements BUSInterface
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PaymentsBUS();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->refreshData();
    }

    public function getAllModels(): array
    {
        return PaymentsDAO::getInstance()->getAll();
    }

    public function refreshData(): void
    {
        PaymentsDAO::getInstance()->readDatabase();
    }

    public function getModelById(int $id)
    {
        return PaymentsDAO::getInstance()->getById($id);
    }

    public function addModel($paymentModel): int
    {
        $this->validateModel($paymentModel);
        return PaymentsDAO::getInstance()->insert($paymentModel);
    }

    public function updateModel($paymentModel): int
    {
        $this->validateModel($paymentModel);
        return PaymentsDAO::getInstance()->update($paymentModel);
    }

    public function deleteModel($paymentModel): int
    {
        return PaymentsDAO::getInstance()->delete($paymentModel);
    }

    public function searchModel(string $value, array $columns)
    {
        return PaymentsDAO::getInstance()->search($value, $columns);
    }

    private function validateModel($paymentModel)
    {
        if ($paymentModel->getOrderId() == null || $paymentModel->getOrderId() == "") {
            throw new InvalidArgumentException("Please fill in all fields");
        }
    }
}
