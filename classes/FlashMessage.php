<?php
namespace Classes;

class FlashMessage {
    public static function setMessage($message, $type = 'error') {
        if (isset($_SESSION) || session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_type'] = $type;
        }
    }

    public static function setSuccess() {
        self::setMessage('Operación exitosa', 'exito');
    }

    public static function setError() {
        self::setMessage('Error en la operación', 'error');
    }
    
    public static function getMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'];
            
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            
            return [$type => [$message]];
        }
        return [];
    }
    
    public static function hasMessage() {
        return isset($_SESSION['flash_message']);
    }
}