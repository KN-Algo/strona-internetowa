<?php 

namespace Eddy\KnAlgo\api;

require __DIR__ . "/../../vendor/autoload.php";

use Eddy\KnAlgo\mail\Mailer;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['message']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
    $response = [
        "icon" => "warning",
        "title" => "Chwila!",
        "message" => "Nie wszystkie pola zostały wypełnione.",
        "footer" => "Error: 400",
        "data" => [
            "error" => null,
            "code" => 400,
        ]
    ];
    die(json_encode($response));
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = [
        "icon" => "warning",
        "title" => "Chwila!",
        "message" => "Niepoprawny adres e-mail.",
        "footer" => "Error: 401",
        "data" => [
            "error" => null,
            "code" => 401,
        ]
    ];
    die(json_encode($response));
}

$mailer = new Mailer();

for ($i = 0; $i < 3; $i++) {
    $response = [];
    $response = $mailer->sendContactMail($name, $email, $subject, $message);
    if ($response['data']['code'] === 200)
        break;
}

die(json_encode($response));