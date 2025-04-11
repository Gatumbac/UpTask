<?php

namespace Model;

class Project extends ActiveRecord {
    protected static $dbTable = 'PROJECTS';
    protected static $dbColumns = ['id', 'name', 'url', 'user_id'];

    protected $id;
    protected $name;
    protected $url;
    protected $user_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setUrl($url) {
        $this->url = $url;
    }
    
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function validate() {
        self::$alerts = [];
        if (!$this->name || strlen($this->name) < 4 || strlen($this->name) > 60) {
            self::$alerts['error'][] = 'El nombre del proyecto es obligatorio y debe ser válido';
        } 
        return self::$alerts;
    }
}