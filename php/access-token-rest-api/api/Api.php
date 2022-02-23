<?php

namespace App\Api;

use App\Src\CustomFunctions;

class Api
{
    public function delete_query_string($url)
    {
        return parse_url($url, PHP_URL_PATH);
    }


    public function get_url_resource($url)
    {
        $url_arr = $this->_url_to_array($url);
        return $url_arr[URL_RESOURCE_INDEX];
    }

    public function get_allowed_resources()
    {
        return [
            'tasks',
        ];
    }

    public function get_url_id($url): ?int
    {
        $url_arr = $this->_url_to_array($url);

        return $url_arr[URL_RESOURCE_ID_INDEX] ?? null;
    }

    public function get_allowed_resources_methods()
    {
        return [
            'GET',
            'POST',
        ];
    }

    public function get_allowed_resources_methods_with_id()
    {
        return [
            'GET',
            'PUT',
            'PATCH',
            'DELETE',
        ];
    }

    private function _url_to_array($url)
    {
        return explode(URL_DELIMETER, $url);
    }

    public function get_api_key()
    {
        /** If there is api key return */
        if (!empty($_SERVER['HTTP_X_API_KEY'])) return $_SERVER['HTTP_X_API_KEY'];

        CustomFunctions::display_error('Provide api key', 400);
    }

    public function check_valid_user($user)
    {
        if (!array_key_exists('id', $user)) CustomFunctions::display_error('Wrong api key given', 401);
    }

    public function check_if_valid_resource($rest_resource, $allowed_resources)
    {
        if (!in_array($rest_resource, $allowed_resources)) CustomFunctions::display_error('Wrong resource name', 404);
    }

    public function check_if_there_is_proper_method_or_id($url_id, $url_method, $allowed_resources_methods, $allowed_resources_methods_with_id)
    {
        /** There is ID and there is not method in $allowed_resources_methods */
        if (!isset($url_id) && !in_array($url_method, $allowed_resources_methods)) CustomFunctions::display_error('Wrong method specified', 405, $allowed_resources_methods_with_id);

        /** There is ID and there is not method in $allowed_resources_methods_with_id */
        if (isset($url_id) && !in_array($url_method, $allowed_resources_methods_with_id))  CustomFunctions::display_error('No id provided', 405, $allowed_resources_methods);
    }
}
