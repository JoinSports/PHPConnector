<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'authuser.class.php';
include_once 'checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$username = $json_decoded->username;
$teamname = $json_decoded->teamname;
if (Inputcheck::username($username) && Inputcheck::name($teamname)) {
// connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

// execute sql query
        $sql = "SELECT team.id FROM team WHERE team.teamname='$teamname';";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $teamid = $row['id'];
        
        
        $sql = "DELETE FROM team WHERE team.teamname = '$teamname';";
        $mysqli->query($sql);
        $sql = "DELETE FROM teamuserc WHERE teamuserc.teamid = '$teamid';";
        $mysqli->query($sql);

        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Team erfolgreich entfernt.";
        } else {
            $json['status'] = "error";
            $json['message'] = "Der Teamname existiert nicht.";
        }
        $json['data'] = "";
    }
} else {
    $json['status'] = "error";
    $json['message'] = "Input konnte nicht validiert werden.";
    $json['data'] = "";
}

// echo JSON this is used by the app
echo json_encode($json);
?>
