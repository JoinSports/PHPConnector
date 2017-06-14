<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$userid = $json_decoded->userId; // string
$teamid = $json_decoded->teamId;
$json = array();
if (Inputcheck::digit($userid) && Inputcheck::digit($teamid)) {
// connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

// execute sql query
        
        $sql = "INSERT INTO teamuserc VALUES ('$teamid', '$userid');";
        $mysqli->query($sql);

        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Team erfolgreich beigetreten.";
        } else {
            $json['status'] = "error";
            $json['message'] = "Dem Team konnte nicht beigetreten werden.";
        }
        $json['data'] = "";
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