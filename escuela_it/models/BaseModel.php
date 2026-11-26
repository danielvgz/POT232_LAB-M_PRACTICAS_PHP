<?php
require_once BASE_PATH . '/config/database.php';

class BaseModel
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }
}
