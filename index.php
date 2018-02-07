<?php
/**
 * Created by Natalie Wiser-Orozco
 * Date: 2/6/18
 * Time: 4:43 PM
 */

// the API file
require_once 'apiFunctions.php';

// creates a new instance of the api class
$api = new api();

// message to return
$message = array();

$data = $api->get();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (is_array($data = $api->get())) {
        $message["code"] = "0";
        $message["data"] = $data;
    } else {
        $message["code"] = "1";
        $message["message"] = "Error on get method";
    }
}
else
{
    $message["code"] = "1";
    $message["message"] = "Unknown method " . $_POST["action"];
}

//the JSON message
header('Content-type: application/json; charset=utf-8');
echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHED);

?>