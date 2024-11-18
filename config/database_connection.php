<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "renginiu_kalendorius_1";

$dbc = mysqli_connect($server, $user, $password, $db);
if (!$dbc) {
    die("Unable to connect to MySQL: " . mysqli_connect_error());
}
?>
