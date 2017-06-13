<?php

require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$userid = $json_decoded->id;
$username = $json_decoded->username;
$passwordhash = $json_decoded->password;
$authusername = $json_decoded->authusername;
$authpasswordhash = $json_decoded->authpassword;
$firstname = $json_decoded->firstname;
$lastname = $json_decoded->lastname;
$email = $json_decoded->email;

$json = array();
if (Inputcheck::digit($userid) && Inputcheck::username($username) && Inputcheck::passwordhash($passwordhash) && Inputcheck::username($authusername) && Inputcheck::passwordhash($authpasswordhash) && Inputcheck::name($firstname) && Inputcheck::name($lastname) && Inputcheck::email($email)) {
    // connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {
        if (AuthUser::authme($authusername, $authpasswordhash)) {
            // execute sql query
            $sql = "UPDATE users SET `username` = '$username', `passwordhash` = '$passwordhash', `firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email' WHERE `userid` = '$userid';";
            $mysqli->query($sql);

            // build output dataset.
            if (!$mysqli->error) {
                $json['status'] = "success";
                $json['message'] = "Nutzer erfolgreich erstellt.";
            } else {
                $json['status'] = "error";
                $json['message'] = "Fehler beim Update.";
            }
            $json['data'] = "";
        } else {
            $json['status'] = "error";
            $json['message'] = "Fehler beim Update.";
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