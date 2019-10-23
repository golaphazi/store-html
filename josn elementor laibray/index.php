<?php
define("DIR_PATH", realpath( __DIR__) );

include 'operation.php';

$obj = new operation();
$obj->data( DIR_PATH.'/2019' );