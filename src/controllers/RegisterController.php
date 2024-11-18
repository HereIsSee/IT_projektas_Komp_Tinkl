<?php
require_once '../config/database_connection.php';
require_once '../src/models/UserModel.php';

$userModel = new UserModel($dbc);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $vardas = mysqli_real_escape_string($dbc, $_POST['vardas']);
	$el_pastas = mysqli_real_escape_string($dbc, $_POST['el_pastas']);
	$slaptazodis = password_hash($_POST['slaptazodis'], PASSWORD_DEFAULT);
	$role = mysqli_real_escape_string($dbc, $_POST['role']);

    if($userModel->isUserExists($vardas, $el_pastas)){
        $message = "<h2> Error: Username or email already exists.</h2>";
    } else {
        if ($userModel->registerUser($vardas, $el_pastas,$slaptazodis, $role)){
            $message = "<h2>Sėkminga registracija!</h2>";
        } else {
            $message = "<h2>Error: " . $dbc->error . "</h2>";
        }
    }
}
?>