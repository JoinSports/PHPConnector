<?php
// hole die configuration der DB
require_once 'config/cfg.php';
include_once 'authuser.class.php';
include_once 'checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$username = $json_decoded->username;
$passwordhash = $json_decoded->authpassword;
$authusername = $json_decoded->authusername;
if (Inputcheck::username($username) && Inputcheck::passwordhash($passwordhash) && Inputcheck::username($authusername)) {
// connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

// execute sql query
   $sql = "DELETE FROM user WHERE user.username='$username' AND user.passwordhash='$passwordhash' AND user.username='$authusername';";
       $mysqli->query($sql);
      

        // build output dataset.
        if (!$mysqli->error) {
            if($mysqli->affected_rows == 1) {
                $json['status'] = "success";
                $json['message'] = "Nutzer wurde entfernt."; 
            } else {
                $json['status'] = "error";
                $json['message'] = "Nutzer konnte nicht entfernt werden, da nicht mehr vorhanden."; 
            }
        } else {
            $json['status'] = "error";
            $json['message'] = "Es gab einen Fehler beim Entfernen.";
        }
        
    }
} else {
    $json['status'] = "error";
    $json['message'] = "Input konnte nicht validiert werden.";
    $json['data'] = "";
}

// echo JSON this is used by the app
echo json_encode($json);