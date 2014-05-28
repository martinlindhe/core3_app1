<?php

header('Content-Type: application/json'); // /XXX right?

$arr = array(
	array('id'=>1, 'name'=>"mr mr", 'decimalNumber'=>12.13, 'datestamp'=>1400078166806),
	array('id'=>2, 'name'=>"arbar", 'decimalNumber'=>10.13, 'datestamp'=>1200078556806),
	array('id'=>3, 'name'=>"zerker", 'decimalNumber'=>0, 'datestamp'=>1100074166806),
	array('id'=>4, 'name'=>"kerps", 'decimalNumber'=>1.99999997, 'datestamp'=>1003338166806),
	array('id'=>5, 'name'=>"overrp", 'decimalNumber'=>5, 'datestamp'=>900078166806),
);

echo json_encode($arr);
