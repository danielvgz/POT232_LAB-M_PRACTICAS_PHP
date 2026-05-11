<?php
require_once __DIR__ . '/../config/database.php';

class ModelBase
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = Database::connect();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
