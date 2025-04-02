<?php
namespace Classes;

class FlashMessage {
    public static function setMessage($mensaje, $tipo = 'error') {
        if (isset($_SESSION) || session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['flash_mensaje'] = $mensaje;
            $_SESSION['flash_tipo'] = $tipo;
        }
    }

    public static function setExito() {
        self::setMessage('Operación exitosa', 'exito');
    }

    public static function setError() {
        self::setMessage('Error en la operación', 'error');
    }
    
    public static function getMessage() {
        if (isset($_SESSION['flash_mensaje'])) {
            $mensaje = $_SESSION['flash_mensaje'];
            $tipo = $_SESSION['flash_tipo'];
            
            // Limpiar el mensaje
            unset($_SESSION['flash_mensaje']);
            unset($_SESSION['flash_tipo']);
            
            return [ $tipo => [$mensaje]];
        }
        return [];
    }
    
    public static function hasMessage() {
        return isset($_SESSION['flash_mensaje']);
    }
}