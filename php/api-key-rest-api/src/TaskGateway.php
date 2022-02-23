<?php

namespace App\Src;

class TaskGateway
{
    private $_db_table = 'tasks';
    private $_dbc = null;

    public function __construct(
        // private $_dbc
        $dbc
    ) {
        $this->_dbc = $dbc;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->_db_table} WHERE user_id={$this->_user_id} ORDER BY name";

        $stmt = $this->_dbc->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function get(int $id)
    {
        $sql = "SELECT * FROM {$this->_db_table} WHERE id=:id AND user_id=:$this->_user_id";

        $stmt = $this->_dbc->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $name = $data['name'];
        $priority = !empty($data['priority']) ? $data['priority'] : null;
        $is_completed = !empty($data['is_completed']) ? $data['is_completed'] : 0;

        $sql = "INSERT INTO {$this->_db_table} 
            (name, priority, is_completed, user_id)
            VALUES
            (:name, :priority, :is_completed, :user_id)
            ";

        $stmt = $this->_dbc->prepare($sql);

        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':priority', $priority, \PDO::PARAM_BOOL);
        $stmt->bindParam(':is_completed', $is_completed, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->_user_id, \PDO::PARAM_INT);

        $stmt->execute();

        return $this->_dbc->lastInsertId();
    }

    public function update($data, $id)
    {
        /** Get array keys */
        $data_keys = array_keys($data);
        /** Create key=:key template */
        $what_to_update = array_map(function ($el) {
            return "{$el}=:{$el}";
        }, $data_keys);
        /** Join array to a string */
        $what_to_update_str = implode(", ", $what_to_update);

        /** Create statement */
        $sql = "
            UPDATE {$this->_db_table}
            SET {$what_to_update_str} 
            WHERE id=:id AND
            user_id=:user_id;
        ";

        $stmt = $this->_dbc->prepare($sql);

        /** Bind params */
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $this->_user_id);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":{$key}", $data[$key]);
        }

        $stmt->execute();

        return $id;
    }

    public function delete(string $id): int
    {
        $sql = "
            DELETE FROM {$this->_db_table}
            WHERE id=:id AND
            user_id=:user_id
        ";

        $stmt = $this->_dbc->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $this->_user_id);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function set_user_id(int $user_id)
    {
        $this->_user_id = $user_id;
    }
}
