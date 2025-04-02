<?php

namespace Model;

class User extends ActiveRecord {
    protected static $dbTable = 'USERS';
    protected static $dbColumns = ['id', 'name', 'lastname', 'email', 'password', 'confirmed', 'token'];

    protected $id;
    protected $name;
    protected $lastname;
    protected $email;
    protected $password;
    protected $confirmed;
    protected $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirmed = $args['confirmed'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getLastname() {
        return $this->lastname;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getConfirmed() {
        return $this->confirmed;
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function setConfirmed($confirmed) {
        $this->confirmed = $confirmed;
    }
    
    public function setToken($token) {
        $this->token = $token;
    }

    public function validate() {
        self::$alerts = [];
        self::validateName();
        self::validateEmail();
        self::validatePassword();
        return self::$alerts;
    }

    public function validateName() {
        if (!$this->name || strlen($this->lastname) < 3) {
            self::$alerts['error'][] = 'El nombre es obligatorio y debe ser válido';
        }
        if (!$this->lastname || strlen($this->lastname) < 3) {
            self::$alerts['error'][] = 'El apellido es obligatorio y debe ser válido';
        }
    }

    public function validateEmail() {
        if (!$this->email) {
            self::$alerts['error'][] = 'El email es obligatorio';
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alerts['error'][] = 'Email con formato inválido';
        }
    }

    public function validatePassword() {
        if (!$this->password) {
            self::$alerts['error'][] = 'La contraseña es obligatoria';
        } else if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }
    }
}