<?php

namespace Eddy\KnAlgo\api;

require __DIR__ . '/../../vendor/autoload.php';

use Eddy\KnAlgo\mail\Mailer;

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    header("Location: ../../index.html");

$translations = include(__DIR__ . "/../../translations/pl.php");

if (isset($_POST['lang']) && !empty($_POST['lang'])) {
    $lang = $_POST['lang'];
    $translationFile = __DIR__ . "/../../translations/{$lang}.php";
    if (file_exists($translationFile))
        $translations = include($translationFile);
}

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['message']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])){
    $response = [
        "icon" => "warning",
        "title" => htmlspecialchars($translations['title-warning']),
        "message" => htmlspecialchars($translations['fill-all-fields']),
        "footer" => "Error: 400",
        "data" => [
            "error" => null,
            "code" => 400,
        ]
    ];
    die(json_encode($response));
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $response = [
        "icon" => "warning",
        "title" => htmlspecialchars($translations['title-warning']),
        "message" => htmlspecialchars($translations['email-error']),
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
    $response = $mailer->sendContactMail($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
    if ($response['data']['code'] === 200)
        break;
}

die(json_encode($response));