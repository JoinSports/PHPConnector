<?php

require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$teamid = $json_decoded->id;
$username = $json_decoded->authusername;
$passwordhash = $json_decoded->authpassword;

$json = array();
if (Inputcheck::digit($teamid) && Inputcheck::username($username) && Inputcheck::passwordhash($passwordhash)) {
    // connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {
        if (AuthUser::authme($username, $passwordhash)) {
            // execute sql query
            $sql = "DELETE FROM team WHERE id = '$teamid'";
            $mysqli->query($sql);

            // build output dataset.
            if (!$mysqli->error) {
                $json['status'] = "success";
                $json['message'] = "Nutzer erfolgreich erstellt.";
            } else {
                $json['status'] = "error";
                $json['message'] = "Fehler beim Entfernen.";
            }
            $json['data'] = "";
        } else {
            $json['status'] = "error";
            $json['message'] = "Fehler beim Entfernen.";
        }
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