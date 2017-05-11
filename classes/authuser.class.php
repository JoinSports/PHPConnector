<?php
/*
 * this class authenticates a user by the username and the passwordhash
 */
class AuthUser {
    static public function authme($username,$password){
        //SQL here
        $mysqli = new mysqli(HOST,USER,PASS,DB);
        if ($mysqli->connect_errno) {
            //echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            return false;
        }
        else {
            $sql = "SELECT * FROM user WHERE username='$username' AND passwordhash='$password';";
            $result = $mysqli->query($sql);
            if($result->num_rows == 1) {
                return true;
            } 
            else {
            return false;
            }
        }
    }
}