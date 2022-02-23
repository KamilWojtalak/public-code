<?php

namespace App\Src;

use PDO;

class UserGateway
{
    private $_dbc = null;
    private $_db_table = 'users';

    public function __construct($dbc)
    {
        /** Database connection */
        $this->_dbc = $dbc;
    }

    public function create($name, $username, $password, $api_key)
    {
        $sql = "
            INSERT INTO {$this->_db_table}
            VALUES (
                default,
                :name,
                :username,
                :password,
                :api_key
            );
        ";

        $stmt = $this->_dbc->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':api_key', $api_key);

        $stmt->execute();

        return $this->_dbc->lastInsertId();
    }

    public function get_by_api_key($key)
    {
        $sql = "
            SELECT * FROM {$this->_db_table}
            WHERE api_key=:api_key 
        ";

        $stmt = $this->_dbc->prepare($sql);

        $stmt->bindParam(':api_key', $key);

        $stmt->execute();

        $fetch_all = $stmt->fetchAll();

        if (!$fetch_all) CustomFunctions::display_error('Wrong api key given', 401);

        return $fetch_all[0];
    }

    public function get_user_by_name(string $name) {
        $sql = "
            SELECT * FROM {$this->_db_table}
            WHERE name=:name
        ";

        $stmt = $this->_dbc->prepare($sql);

        $stmt->bindParam(':name', $name);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
