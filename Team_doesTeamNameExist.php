<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

// connect to db


$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$teamname = $json_decoded->teamName;


$json = array();
if (Inputcheck::name($teamname)) {
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {
        $sql = "SELECT * FROM team WHERE teamname='$teamname';";
            $result = $mysqli->query($sql);
            if ($result->num_rows == 0) {
                $json['status'] = "success";
                $json['message'] = "Teamname noch frei.";
            } else {
                $json['status'] = "error";
                $json['message'] = "Team exisitert bereits.";
            }
    }
} else {
    $json['status'] = "error";
    $json['message'] = "Input konnte nicht validiert werden.";
    $json['data'] = "";
}
$json['errorUserMsg'] = "";
$json['errorLogMsg'] = "";
// echo JSON this is used by the app
echo json_encode($json);
?>