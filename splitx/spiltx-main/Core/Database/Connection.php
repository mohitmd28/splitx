<?php

namespace Core\Database;

use PDO;

class Connection
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Get PDO object
     * 
     * @return PDO;
     */
    public function getPdo(): PDO
    {
        if (!is_null($this->pdo)) return $this->pdo;

        $dsn = "mysql:dbname=splitx;host=localhost";

        $this->pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        return $this->pdo;
    }
}
