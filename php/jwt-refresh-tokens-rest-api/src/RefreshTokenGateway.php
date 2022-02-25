<?php

namespace App\Src;

use App\Src\Interfaces\GatewayInterface;
use PDO;

class RefreshTokenGateway extends Gateway
{
    private $_dbc = null;
    private $_db_table = 'refresh_tokens';
    private $_key;


    public function __construct($dbc, $key)
    {
        parent::__construct($dbc);
        $this->_key = $key;
    }

    public function create($refresh_token, $expires_at)
    {
        $sql = "
            INSERT INTO {$this->_db_table}
            VALUES (
                :refresh_token,
                :expires_at
            );
        ";

        $stmt = $this->_dbc->prepare($sql);

        $refresh_token = hash_hmac('sha256', $refresh_token, $this->_key);

        $stmt->bindParam(':refresh_token', $refresh_token);
        $stmt->bindParam(':expires_at', $expires_at);

        return $stmt->execute();
    }

    public function delete($refresh_token)
    {
        $sql = "
            DELETE FROM {$this->_db_table}
            WHERE token_hash=:token_hash
        ";

        $stmt = $this->_dbc->prepare($sql);

        $token_hash = hash_hmac('sha256', $refresh_token, $this->_key);

        $stmt->bindParam(':token_hash', $token_hash);

        return $stmt->execute();
    }

    public function get_token_by_token($token)
    {
        $sql = "
            SELECT * FROM {$this->_db_table}
            WHERE token_hash=:token_hash
        ";

        $stmt = $this->_dbc->prepare($sql);

        $token_hash = hash_hmac('sha256', $token, $this->_key);

        $stmt->bindParam(':token_hash', $token_hash);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_expired_tokens()
    {
        $sql = "
            DELETE FROM {$this->_db_table}
            WHERE expires_at < UNIX_TIMESTAMP()
        ";

        $stmt = $this->_dbc->prepare($sql);

        return $stmt->execute();
    }
}
