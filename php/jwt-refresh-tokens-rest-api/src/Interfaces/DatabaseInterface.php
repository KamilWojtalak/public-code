<?php

namespace App\Src\Interfaces;

use PDO;

interface DatabaseInterface
{
    public function __construct(
        string $host,
        string $dbname,
        string $user,
        string $pswd
    );

    public function getConnection(): PDO;
}
