<?php
header('Content-Type: application/json');

if ($param[0] == 'core-register-user') {

    // TODO actually register user

    $input = json_decode(file_get_contents('php://input'));
    if (empty($input->username) || empty($input->password) || empty($input->email)) {

        $res = \Api\ResponseError::asArray(\Api\ResponseError::MISSING_PARAM);

    } else {
        $res = array(
            'status' => 'success',
            'message' => 'user '.$input->username.' registered'
        );
    }

    echo json_encode($res);
} else if ($param[0] == 'core-username-free') {
    // TODO db lookup of name
    $isAvailable = true;

    // parses input variables from ng POST
    $input = json_decode(file_get_contents('php://input'));
    if ($input && $input->username == "hej") {
        $isAvailable = false;
    }

    echo json_encode(array('isAvailable' => $isAvailable));

} else {
    die('invalid path');
}