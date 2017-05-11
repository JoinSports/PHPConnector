<?php

// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$username = $json_decoded->username;
if (Inputcheck::username($username)) {
// connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

// execute sql query
    $sql = "SELECT user.firstname,user.lastname,user.email FROM user WHERE user.username='$username';";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Nutzer erfolgreich geeingelesen.";
            $json['data']['firstname'] = $row['firstname'];
            $json['data']['lastname'] = $row['lastname'];
            $json['data']['email'] = $row['email'];
        } else {
            $json['status'] = "error";
            $json['message'] = "Der Nutzer konnte nicht gelesen werden.";
        }
    }
} else {
    $json['status'] = "error";
    $json['message'] = "Input konnte nicht validiert werden.";
    $json['data'] = "";
}

// echo JSON this is used by the app
echo json_encode($json);

?>