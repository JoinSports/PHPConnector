<?php

/* 
 * ACHTUNG bei preg match wird kein true or flase geliefert sondern INT daher === mit 0 oder == true false
 */
function  abc($param) {
    if (preg_match('/^[a-zA-Z]{1,}$/', $param) === 0) {
        return false;
    } else {
        return true;
    }
}
function  hex($value) {
    if (preg_match("/^[a-fA-F0-9]{1,8}$/", $value ) === 0) {
        return false;
    } else {
        return true;
    }
}


$s1 = "lol";
$result = abc($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "löäüÖÄÜlxxx";
$result = abc($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "abc";
$result = abc($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "1234567";
$result = hex($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "affe1234";
$result = hex($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "affe12346";
$result = hex($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "1234567890abcdefABCDEF";
$result = abc($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "1234567890abcdefABCDEFzzzzzz";
$result = hex($s1);
echo $s1 . " ". $result . "<br>";
$s1 = "abcd00005";
var_dump(preg_match("/^[a-fA-F0-9]{1,8}$/", $s1 ));
?>