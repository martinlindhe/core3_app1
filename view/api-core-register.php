<?php

// TODO actually register user

header('Content-Type: application/json');

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
