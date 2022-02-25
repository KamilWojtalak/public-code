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

    public function check_login_credentials($user, $password)
    {
        if (!$user) {
            CustomFunctions::display_error('Invalid authentication', 401);
        }


        if (!password_verify($password, $user['password'])) {
            CustomFunctions::display_error('Invalid authentication', 401);
        }
    }

    public function get_authorization_header()
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            return $_SERVER['HTTP_AUTHORIZATION'];
        }

        $headers = apache_request_headers();
        return $headers['Authorization'];
    }

    public function authenticate_jwt($header)
    {
        /** Get type and token of Bearer xxtokenxx */
        $type_token = explode(" ", $header);
        $type = $type_token[0] ?? null;
        $jwt = $type_token[1] ?? null;

        /** If type is not `Bearer` */
        if ($type !== 'Bearer') CustomFunctions::display_error('Invalid token type', 401);

        /** JWT */
        $jwtc = new JWTCodec($_ENV['APP_KEY']);
        $jwt = $jwtc->decode($jwt);

        /** Assign user id to private property */
        $this->_user_id = +$jwt['sub'];
    }
}
