<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!isset($_POST['token'])) {
  http_response_code(400);
  echo "Token reCAPTCHA nie został przesłany.";
  exit;
}

$token = $_POST['token'];
$secret = $_ENV['RECAPTCHA_SECRET'];
$verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$token";

$response = file_get_contents($verifyUrl);
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"] || $responseKeys["score"] < 0.5) {
  http_response_code(403);
  echo "Weryfikacja reCAPTCHA nie powiodła się.";
  exit;
}





$requiredFields = ['name', 'email', 'subject', 'message'];
foreach ($requiredFields as $field) {
  if (empty($_POST[$field])) {
    http_response_code(400);
    echo "Wszystkie pola muszą być wypełnione.";
    exit;
  }
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Nieprawidłowy adres e-mail.";
  exit;
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);
