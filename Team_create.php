<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$teamleaderid = $json_decoded->teamLeaderId; // int
$teamname = $json_decoded->teamName;

$json = array();
if (Inputcheck::digit($userid) && Inputcheck::name($teamname)) {
// connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

// execute sql query

        $sql = "INSERT INTO team VALUES ('$teamname', NULL);";
        $mysqli->query($sql);
        $teamid = $mysqli->insert_id;

        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Team erfolgreich erstellt.";

            $sql = "INSERT INTO teamuserc VALUES ('$teamid', '$teamleaderid');";
            $mysqli->query($sql);
            $sql = "INSERT INTO teamleaderc VALUES ('$teamleaderid','$teamid',);";
            $mysqli->query($sql);
        } else {
            $json['status'] = "error";
            $json['message'] = "Der Teamname ist bereits vergeben.";
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