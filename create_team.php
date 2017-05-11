<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$username = $json_decoded->teamleader; // string
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
        $sql = "SELECT user.userid FROM user WHERE user.username='$username';";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $teamleaderid = $row['userid'];
        
        
        $sql = "INSERT INTO team VALUES ('$teamname', NULL, '1', '$teamleaderid', '1', '0', '0', '0');";
        $mysqli->query($sql);
        $teamid = $mysqli->insert_id;
        $sql = "INSERT INTO teamuserc VALUES ('$teamid', '$teamleaderid');";
        $mysqli->query($sql);

        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Team erfolgreich erstellt.";
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

// echo JSON this is used by the app
echo json_encode($json);
?>