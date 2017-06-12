<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

// connect to db


$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$authusername = $json_decoded->authusername;
$authpasswordhash = $json_decoded->authpassword;
$teamid = $json_decoded->id;

$json = array();

if (Inputcheck::username($authusername) && Inputcheck::passwordhash($authpasswordhash) && Inputcheck::digit($teamid)) {
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

        $sql = "Select teamname,id from team where id='$teamid'";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        $json['id'] = $row['id'];
        $json['teamName'] = $row['teamname'];
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
