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
    $isAvailable = true;

    // parses input variables from ng POST
    $input = json_decode(file_get_contents('php://input'));
    
    // TODO db lookup of name
    if ($input && in_array($input->username, array('hej','hejsan'))) {
        $isAvailable = false;
    }

    echo json_encode(array('isAvailable' => $isAvailable));

} else {
    die('invalid path');
}