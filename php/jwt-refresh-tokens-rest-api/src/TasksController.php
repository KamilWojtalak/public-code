<?php

namespace App\Src;

class TasksController implements Controller
{
    private $_user_id;

    public function __construct(
        // private TaskGateway $gateway
        TaskGateway $gateway,
        int $user_id
    ) {
        $this->_user_id = $user_id;
        $this->_gateway = $gateway;
        
        $this->_gateway->set_user_id($this->_user_id);
    }

    public function processRequest(string $method = 'GET', ?int $id): void
    {

        // If there is not id
        if (!isset($id)) {
            if ($method === 'GET') {
                $data = $this->_gateway->getAll();
                CustomFunctions::output_json($data);
            } else {
                $data = CustomFunctions::get_http_input();

                if ($data === []) CustomFunctions::display_error("Invalid JSON format", 401);

                $this->_validate_data($data);

                $last_inserted_id = $this->_gateway->create($data);

                CustomFunctions::output_json($last_inserted_id);
            }
        } else {
            // Get single task record
            $item = $this->_gateway->get($id);

            /** If there is record for specified ID */
            if ($item === []) CustomFunctions::display_error("Item with id: $id does not exist", 404);

            switch ($method) {
                case 'GET':
                    CustomFunctions::output_json($item);
                    break;
                case 'PUT':
                    CustomFunctions::output_json('PUT');
                    break;
                case 'PATCH':
                    $data = CustomFunctions::get_http_input();

                    $this->_validate_data($data, false);

                    $returned_value = $this->_gateway->update($data, $id);

                    CustomFunctions::output_json($returned_value);
                    break;
                case 'DELETE':
                    $returned_value = $this->_gateway->delete($id);
                    CustomFunctions::output_json($returned_value);
                    break;
            }
        }
    }

    private function _validate_data(array $data, bool $is_optional = true): void
    {
        $errors = [];

        /** If name is empty */
        if ($is_optional && empty($data['name'])) $errors[] = 'Name must be specified';

        /** If priority is not empty and priority is not an integer */
        if (!empty($data['priority']) && filter_var($data['priority'], FILTER_VALIDATE_INT) === false) $errors[] = 'Priority must be an integer';

        /** If there are errors display them and exit the script */
        if (!empty($errors)) CustomFunctions::display_error($errors, 422);
    }
}
