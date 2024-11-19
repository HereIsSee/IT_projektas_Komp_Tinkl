<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungti</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../IT_darbas/assets/css/registration_login_box.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Prisijungti</h2>
            <?= $message ?? "" ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="el_pastas">Email addressas</label>
                    <input type="email" class="form-control" id="email" name="el_pastas" required>
                </div>
                <div class="form-group">
                    <label for="slaptazodis">Slaptažodis</label>
                    <input type="password" class="form-control" id="password" name="slaptazodis" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Prisijungti</button>
                <p class="text-center mt-3">
                    <a href="register.php">Neturite prisijungimo? Registruotis</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>