<?php

namespace App\Src;

use App\Src\Interfaces\GatewayInterface;
use PDO;

abstract class Gateway implements GatewayInterface
{
    private $_dbc;
    private $_db_table;

    public function __construct($dbc)
    {
        /** Database connection */
        $this->_dbc = $dbc;
    }
}
