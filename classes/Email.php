<?php
namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    private $email;
    private $name;
    private $token;

    public function __construct($email, $name, $token) {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendAccountConfirmation() {
        $phpmailer = $this->setup($this->email, $this->name, 'Confirma tu cuenta');

        $content = "<html>";
        $content.="<p><strong>Hola " . $this->name . "</strong></p>";
        $content.="<p>Has creado tu cuenta en UpTask, solo debes confirmarla presionando el siguiente enlace: </p>";
        $content .= "<a href='{$_ENV['APP_URL']}/confirmar-cuenta?token={$this->token}'>Confirmar cuenta</a>";
        //$content.="<a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "' >Confirmar cuenta</a>";
        $content.="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $content.= "</html>";
        $phpmailer->Body = $content;
        $phpmailer->send();
    }

    public function sendPasswordInstructions() {
        $phpmailer = $this->setup($this->email, $this->name, 'Reestablece tu password');

        $content = "<html>";
        $content.="<p><strong>Hola " . $this->name . "</strong></p>";
        $content.="<p>Has solicitado reestablecer tu password en UpTask, da click en el siguiente enlace para hacerlo: </p>";
        $content .= "<a href='{$_ENV['APP_URL']}/resetear-password?token={$this->token}'>Reestablecer password</a>";
        //$content.="<a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "' >Reestablecer password</a>";
        $content.="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $content.= "</html>";
        $phpmailer->Body = $content;
        $phpmailer->send();
    }

    public function setup($recipientEmail, $recipientName, $subject) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];

        $phpmailer->setFrom('cuentas@uptask.com');
        $phpmailer->addAddress($recipientEmail, $recipientName);
        $phpmailer->Subject = $subject;

        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        return $phpmailer;
    }
}