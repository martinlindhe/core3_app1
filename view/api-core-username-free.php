<?php

// TODO db lookup of name
$isAvailable = true;

// parses input variables from ng. TODO why dont angular use normal POST body?
$input = json_decode(file_get_contents('php://input'));
if ($input->username == "hej") {
    $isAvailable = false;
}

header('Content-Type: application/json');
echo json_encode(array('isAvailable' => $isAvailable));
