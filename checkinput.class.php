<?php

/* 
 * this class is a set of input validation used by all other input functions
 * update needed sometimes 
 */
class Inputcheck{
    static public function letter($string) {
        if(preg_match("/^[a-zA-Z]{1,}$/", $string) === 0) {
            return false;
        } else {
            return true;
        }
    }
    static public function digit($string) {
        if(preg_match("/^[0-9]{1,}$/", $string) === 0) {
            return false;
        } else {
            return true;
        }
    }
    static public function passwordhash($string) {
        if(preg_match("/^[a-fA-F0-9]{5,130}$/", $string) === 0) {
            return false;
        } else {
            return true;
        }
    }
    static public function username($string) {
        if(preg_match("/^[a-zA-Z0-9]{3,50}$/", $string) === 0) {
            return false;
        } else {
            return true;
        }
    }
    static public function name($string) {
        if(preg_match("/^[a-zA-Z0-9]{2,254}$/", $string) === 0) {
            return false;
        } else {
            return true;
        }
    }
    static public function email($string) {
        if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }
}
