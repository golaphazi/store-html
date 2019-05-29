<?php
const DIR_URL = 'http://localhost/elementor-layouts/'; 
define("DIR_PATH", realpath( __DIR__) );

isset($_REQUEST['action']) || exit;

$action = $_REQUEST['action'];

include('functions.php');
$processor = New Data_Processor();

switch($action){
    case 'get_layouts':
        $data = $processor->get_list($_GET['tab']);

        echo json_encode(
            [
                'success' => true,
                'data' => $data 
            ]
        );
        exit;
        break;

    case 'get_layout_data':
        $data = file_get_contents($processor->get_data($_GET['id']));
        echo $data;
        break;
}