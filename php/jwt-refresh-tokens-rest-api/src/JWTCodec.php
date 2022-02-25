<?php

namespace App\Src;

use Dotenv\Exception\InvalidPathException;

class JWTCodec
{
    private $_key;
    public function __construct($key)
    {
        $this->_key = $key;
    }
    public function encode($data)
    {
        /** What should be in header part */
        $what_in_header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];

        /** Encode header and payload to base64 url string */
        $header = $this->_base64_url_encode(json_encode($what_in_header));
        $payload = $this->_base64_url_encode(json_encode($data));

        /** Get signature hash in binary */
        $signature_hash = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            $this->_key,
            true
        );

        /** url binary hash */
        $signature = $this->_base64_url_encode($signature_hash);

        /** Return JWT token */
        return $header . "." . $payload . "." . $signature;
    }

    public function decode($jwt)
    {
        [$header, $payload, $signature_from_jwt] = explode(".", $jwt);

        $signature_hash = hash_hmac(
            'sha256',
            $header . '.' . $payload,
            $this->_key,
            true
        );

        /** Get url encoded signature hash */
        $signature_hash = $this->_base64_url_encode($signature_hash);

        /** Check if signatures match */
        if (!($signature_hash === $signature_from_jwt)) CustomFunctions::display_error('Invalid JWT token', 401);

        /** Decode payload */
        $payload = json_decode($this->_base64_url_decode($payload), true);

        /** Check if token has expired */
        if ($payload['exp'] < time()) CustomFunctions::display_error('JWT has expired', 401);

        /** Return decoded $payload */
        return $payload;
    }

    private function _base64_url_encode(string $input): string
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($input)
        );
        // return strtr(base64_encode($input), '+/=', '-_');
    }

    private function _base64_url_decode(string $input): string
    {
        return str_replace(
            ['-', '_'],
            ['+', '/'],
            base64_decode($input)
        );
        // return base64_decode(strtr($input, '_-', '/+'));
    }

    public function get_refresh_token_exp() {
        return time() + JWT_REFRESH_TOKEN_EXPIRATION_TIME;
    }
}