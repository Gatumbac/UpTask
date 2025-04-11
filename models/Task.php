<?php

namespace Model;

class Task extends ActiveRecord {
    protected static $dbTable = 'TASKS';
    protected static $dbColumns = ['id', 'name', 'status', 'project_id'];

    protected $id;
    protected $name;
    protected $status;
    protected $project_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->status = $args['status'] ?? 0;
        $this->project_id = $args['project_id'] ?? '';
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function getProjectId() {
        return $this->project_id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function setProjectId($project_id) {
        $this->project_id = $project_id;
    }

    public function validate() {
        self::$alerts = [];
        if (!$this->name || strlen($this->name) < 4 || strlen($this->name) > 60) {
            self::$alerts['error'][] = 'El nombre de la tarea es obligatorio y debe ser válido';
        } 
        return self::$alerts;
    }
}