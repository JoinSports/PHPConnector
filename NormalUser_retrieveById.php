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
$userid = $json_decoded->id;

$json = array();

if (Inputcheck::username($authusername) && Inputcheck::passwordhash($authpasswordhash) && Inputcheck::digit($userid)) {
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

        $sql = "Select userid,username,firstname,lastname,email from users where userid='$userid'";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        $json['id'] = $row['userid'];
        $json['username'] = $row['username'];
        $json['firstname'] = $row['firstname'];
        $json['lastname'] = $row['lastname'];
        $json['email'] = $row['email'];
        $json['password'] = "";
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
