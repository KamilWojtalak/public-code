<?php

namespace App\Src;

use PDO;

class Database
{
    private ?PDO $dbc = null;

    public function __construct(
        /** as of PHP 8.0 */
        // private string $_host,
        // private string $_dbname,
        // private string $_user,
        // private string $_pswd
        string $host,
        string $dbname,
        string $user,
        string $pswd
    ) {
        $this->_host = $host;
        $this->_dbname = $dbname;
        $this->_user = $user;
        $this->_pswd = $pswd;
    }

    public function getConnection(): PDO
    {
        /** If there is already set database connection return it */
        if($this->dbc) return $this->dbc;

        /** Set the dsn */
        $dsn = "mysql:host={$this->_host};dbname={$this->_dbname}";

        /** PDO options */
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        /** Return PDO conn */
        $this->dbc = new PDO($dsn, $this->_user, $this->_pswd, $options);

        return $this->dbc;
    }
}
