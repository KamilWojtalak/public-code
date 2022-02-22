<?php

namespace App\Src;

class Auth
{
    private $_dbc = null;
    public $_user_id = 0;

    public function __construct($dbc)
    {
        /** Database connection */
        $this->_dbc = $dbc;
    }

    public function auth_by_api_key($api_key)
    {
        /** Get user gateway */
        $user_gateway = new UserGateway($this->_dbc);

        /** Get user by api key */
        $user = $user_gateway->get_by_api_key($api_key);

        /** Get user id */
        $this->_user_id = +$user['id'];
    }

    public function get_user_id()
    {
        return $this->_user_id;
    }
}
