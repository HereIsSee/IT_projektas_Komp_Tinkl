<?php
require_once '../config/database_connection.php';
require_once '../src/models/User.php';

session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userModel = new User($dbc);

    $el_pastas = mysqli_real_escape_string($dbc, $_POST['el_pastas']);
    $slaptazodis = $_POST['slaptazodis'];

    $user = $userModel->findUserByEmail($el_pastas);

    if($user){
        if(password_verify($slaptazodis, $user['slaptazodis'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['vaidmuo'] = $user['vaidmuo'];
            if($user['vaidmuo'] == 'vip'){                
                $_SESSION['vip_specialization'] = $user['vip_specializacija'];
            }
            $_SESSION['vardas'] = $user['vardas'];
            header("Location: dashboard.php");
            exit();
        } else{
            $message = '<p style="color: red;">Incorrect password</p>';
        }
    } else {
        $message = '<p style="color: red;">No account found with that email</p>';
    }
}
?>