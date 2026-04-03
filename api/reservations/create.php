<?php
header("Content-type:application/json; charset=utf-8");
require_once __DIR__ . "/../../config/functions.php";

$raw= file_get_contents("php://input");
$data=json_decode("raw");

echo $data;
