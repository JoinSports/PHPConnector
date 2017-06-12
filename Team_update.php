<?php

require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$teamid = $json_decoded->id;
$teamname = $json_decoded->teamName;

$json = array();
if (Inputcheck::digit($teamid) && Inputcheck::username($teamname)) {
    // connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {
            // execute sql query
            $sql = "UPDATE team SET `teamname` = '$teamname' WHERE `id` = '$teamid';";
            $mysqli->query($sql);

            // build output dataset.
            if (!$mysqli->error) {
                $json['status'] = "success";
                $json['message'] = "Team erfolgreich updated.";
            } else {
                $json['status'] = "error";
                $json['message'] = "Fehler beim Update.";
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

// return JSON this is used by the app
echo json_encode($json);
?>