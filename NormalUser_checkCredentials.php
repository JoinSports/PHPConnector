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
if (Inputcheck::username($authusername) && Inputcheck::passwordhash($authpasswordhash)) {
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {
        if (AuthUser::authme($authusername, $authpasswordhash)) {
            // wenn auth true liefert
            // execute sql query da auth gueltig war

            $json['status'] = "success";
            $json['message'] = "Erfolgreich angemeldet.";
            $json['data'] = "";
        } else {
            // wenn auth false ist
            $json['status'] = "error";
            $json['message'] = "Benutzername oder Password falsch. Bitte erneut versuchen.";
            $json['data'] = "";
        }
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