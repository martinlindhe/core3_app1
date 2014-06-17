<?php

$doc = new \Writer\DocumentXhtml();



$mark = new \JsMap\GoogleMapMarker(-34.397, 150.644);

$map = new \JsMap\Google();

$map->addMarker($mark);
$map->renderToDocument($doc);


echo $doc->render();
