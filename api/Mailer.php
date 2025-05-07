<?php

namespace Eddy\KnAlgo\mail;

require __DIR__ . '/../../vendor/autoload.php';

use Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");

try {
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    $error = "Error loading .env file: " . $e->getMessage();
    die($error);
}

class Mailer {
    private PHPMailer|null $mail = null;
    private array $translations = [];
    function __construct($lang="pl")
    {
        if ($_ENV['PRODUCTION'] === "true") {
            error_reporting(0);
            ini_set('display_errors', 0);
            $this->mail = new PHPMailer(false);
            $this->mail->SMTPDebug = 0;
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = 3;
            $this->mail->Debugoutput = 'html';
        }
        $this->mail->CharSet = "UTF-8";
        $this->mail->SMTPAuth = TRUE;
        $this->mail->SMTPAutoTLS = true;
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->SMTPKeepAlive = true;
        $this->mail->Host = $_ENV["SERWER_SMTP"];
        $this->mail->Port = $_ENV["PORT_SMTP"];
        $this->mail->WordWrap = 50;
        $this->mail->Priority = 1;
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->Username = $_ENV["USER_SMTP"];
        $this->mail->Password = $_ENV["PASS_SMTP"];
        $this->mail->setFrom($_ENV["FROM_MAIL"], "Formularz na stronie KN ALGO");
        $this->mail->From = $_ENV["FROM_MAIL"];
        $this->mail->FromName = "KN ALGO - Formularz";
        $translationFile = __DIR__ . "/../../translations/{$lang}.php";
        if (file_exists($translationFile)) {
            $this->translations = include($translationFile);
        } else {
            $this->translations = include(__DIR__ . "/../../translations/pl.php");
        }
    }

    public function sendContactMail(string $name, string $email,
     string $subject, string $message) {
        try {
            $this->mail->addAddress($_ENV["TO_MAIL"]);
            $this->mail->Subject = $subject . " - " . $name;
            $this->mail->Body = "
                <h1>Wiadomość od: $name</h1>
                <h2>Email: $email</h2>
                <p>$message</p>
                <p>Data wysłania: " . date("Y-m-d H:i:s") . "</p>
                <p>Wiadomość wysłana z formularza na stronie KN ALGO</p>
            ";
            $this->mail->AltBody = "
                Wiadomość od: $name\n
                Email: $email\n
                $message
                \n
                Data wysłania: " . date("Y-m-d H:i:s") . "\n\n
                Wiadomość wysłana z formularza na stronie KN ALGO";
            if (!$this->mail->send()) {
                $response = [
                    "icon" => "error",
                    "title" => htmlspecialchars($this->translations['title-failure']),
                    "message" => htmlspecialchars($this->translations['contact-admin']),
                    "footer" => "Error: 510",
                    "data" => [
                        "error" => $this->mail->ErrorInfo,
                        "code" => 510,
                    ]
                ];
            } else {
                $response = [
                    "icon" => "success",
                    "title" => htmlspecialchars($this->translations['title-success']),
                    "message" => htmlspecialchars($this->translations['message-success']),
                    "footer" => htmlspecialchars($this->translations['footer-success']),
                    "data" => [
                        "error" => null,
                        "code" => 200,
                    ]
                ];
            }
        } catch (Exception $e) {
            $response = [
                "icon" => "error",
                "title" => htmlspecialchars($this->translations['title-error']),
                "message" => htmlspecialchars($this->translations['contact-admin']),
                "footer" => "Error: 511",
                "data" => [
                    "error" => $e->getMessage(),
                    "code" => 511,
                ]
            ];
        }
        return $response;
    }
}