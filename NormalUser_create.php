<?php

require_once 'config/cfg.php';
include_once 'classes/authuser.class.php';
include_once 'classes/checkinput.class.php';

$json_string = $_POST['json'];
$json_decoded = json_decode($json_string);

//input params
$username = $json_decoded->username;
$passwordhash = $json_decoded->password;
$firstname = $json_decoded->firstname;
$lastname = $json_decoded->lastname;
$email = $json_decoded->email;
$json = array();

if (Inputcheck::username($username) && Inputcheck::passwordhash($passwordhash) && Inputcheck::name($firstname) && Inputcheck::name($lastname) && Inputcheck::email($email)) {
    // connect to db
    $mysqli = new mysqli(HOST, USER, PASS, DB);
    if ($mysqli->connect_errno) {
        //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        $json['status'] = "error";
        $json['message'] = "Fehler 404";
        $json['data'] = "";
    } else {

        // execute sql query
        $sql = "INSERT INTO users VALUES (NULL, '$username', '$passwordhash', '$firstname', '$lastname', '$email');";
        $mysqli->query($sql);

        // build output dataset.
        if (!$mysqli->error) {
            $json['status'] = "success";
            $json['message'] = "Nutzer erfolgreich erstellt.";
        } else {
            $json['status'] = "error";
            $json['message'] = "Der Nutzername ist bereits vergeben.";
        }
        $json['data'] = "";
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