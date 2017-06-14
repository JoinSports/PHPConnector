<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

// connect to db


$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$userid = $json_decoded->userId;
$authusername = $json_decoded->authusername;
$authpasswordhash = $json_decoded->authpassword;

$json = array();

if (Inputcheck::username($authusername) && Inputcheck::passwordhash($authpasswordhash) && Inputcheck::digit($userid)) {
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

        $sql = "SELECT id from team,teamuserc where teamuserc.teamid = team.id AND teamuserc.userid !='$userid'";
        $result = $mysqli->query($sql);

        $teams_a = array();
        while ($row = mysqli_fetch_assoc($result)) {
            
            $teams_a[] = $row['id'];
        }
        
        $json['teamIds'] = $teams_a;
        $json['status'] = "success";
        $json['message'] = "";
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

