<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "renginiu_kalendorius";

$dbc = mysqli_connect($server, $user, $password, $db);
if (!$dbc) {
    die("Unable to connect to MySQL: " . mysqli_connect_error());
}
?>
