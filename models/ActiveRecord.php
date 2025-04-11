<?php
namespace Model;

abstract class ActiveRecord implements \JsonSerializable {
    protected static $db;
    protected static $dbTable = '';
    protected static $dbColumns = [];
    protected static $alerts = [];
    protected $id;

    protected static $lastError = '';

    protected static function recordError($message) {
        self::$lastError = $message;
    }
    
    public static function getLastError() {
        return self::$lastError;
    }

    public abstract function validate();

    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlert($type, $message) {
        static::$alerts[$type][] = $message;
    }

    public static function getAlerts() {
        return static::$alerts;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$dbTable;
        $array = static::queryTable($query);
        return $array;
    }

    public static function get($number, $order) {
        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            static::recordError("Invalid order parameter.");
            return [];
        }

        $number = intval($number);
        $query = "SELECT * FROM " . static::$dbTable . " ORDER BY id {$order} LIMIT {$number}";
        $array = static::queryTable($query);
        return $array;
    }

    public static function find($id) {
        $id = self::$db->escape_string($id);
        $query = "SELECT * FROM " . static::$dbTable . " WHERE id = {$id}";
        $result = static::queryTable($query);
        return array_shift($result);
    }

    public static function where($column, $value) {
        $column = self::$db->escape_string($column);
        $value = self::$db->escape_string($value);
        $query = "SELECT * FROM " . static::$dbTable . " WHERE " . $column . " = '{$value}'";
        $result = static::queryTable($query);
        return array_shift($result);
    }

    public static function belongsTo($column, $value) {
        $column = self::$db->escape_string($column);
        $value = self::$db->escape_string($value);
        $query = "SELECT * FROM " . static::$dbTable . " WHERE " . $column . " = '{$value}'";
        return static::queryTable($query);
    }

    //Unrestricted querys
    public static function SQL($query) {
        $array = static::queryTable($query);
        return $array;
    }

    public function save() {
        if(!$this->id) {
            $result = $this->create();
        } else {
            $result = $this->update();
        }
        return $result ?? false;
    }
    
    public function create() {
        $attributes = $this->sanitizeData();
        $stringColumns = join(", ", array_keys($attributes));
        $stringValues = join("', '", array_values($attributes));

        $query = "INSERT INTO " . static::$dbTable ."(" . $stringColumns . ") VALUES ('" . $stringValues . "')";

        try {
            $result = self::$db->query($query);
        } catch (\Throwable $th) {
            static::recordError($th->getMessage());
        }

        return [
            'result' =>  $result ?? false,
            'error' => static::getLastError(),
            'id' => self::$db->insert_id
         ];
    }

    public function update() {
        $attributes = $this->sanitizeData();
        $values = [];

        foreach($attributes as $key=>$value) {
            if ($value === "NULL") {
                $values[] = "{$key}=NULL";
            } else {
                $values[] = "{$key}='{$value}'";
            }
        }

        $id = self::$db->escape_string($this->id);
        $query = "UPDATE ". static::$dbTable ." SET " . join(", ", $values) . " WHERE id = '{$id}' LIMIT 1";

        try {
            $result = self::$db->query($query);
        } catch (\Throwable $th) {
            static::recordError($th->getMessage());
        }

        return $result ?? false;
    }

    public function delete() {
        $id = self::$db->escape_string($this->id);
        $query = "DELETE FROM " . static::$dbTable . " WHERE id={$id} LIMIT 1";

        try {
            $result = self::$db->query($query);
        } catch (\Throwable $th) {
            static::recordError($th->getMessage());
        }

        return $result ?? false;
    }

    public function getAttributes() {
        $attributes = [];
        foreach (static::$dbColumns as $column) {
            if ($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    public function sanitizeData() {
        $attributes = $this->getAttributes();
        $sanitized = [];

        foreach ($attributes as $column => $value) {
            if ($value === null) {
                $sanitized[$column] = "NULL";
            } else {
                if (is_string($value)) {
                    $value = trim($value);
                }
                $sanitized[$column] = self::$db->escape_string($value);
            }
        }
        return $sanitized;
    }

    public static function queryTable($query) {
        $result = self::$db->query($query);
        $array = [];
        while ($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }
        return $array;
    }

    public static function createObject(array $record) {
        $object = new static($record);
        return $object;
    }

    public function sync(array $attributes = []) {
        foreach($attributes as $attribute=>$value) {
            if (property_exists($this, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }

    public function jsonSerialize(): mixed {
        $vars = get_object_vars($this);
        return $vars;
    }
}