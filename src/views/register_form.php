<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../IT_darbas/assets/css/registration_login_box.css">
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2>Registruotis</h2>
            <?=$message ?? "" ?>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="vardas">Vardas:</label>
                    <input type="text" class="form-control" id="vardas" name="vardas" required>
                </div>
                <div class="form-group">
                    <label for="el_pastas">Email:</label>
                    <input type="email" class="form-control" id="el_pastas" name="el_pastas" required>
                </div>
                <div class="form-group">
                    <label for="slaptazodis">Slaptažodis:</label>
                    <input type="password" class="form-control" id="slaptazodis" name="slaptazodis" required>
                </div>
                <div class="form-group">
                    <label for="role">Pasirinkite rolę:</label>
                    <select name="role" id="role" class="form-control">
                        <option value="vartotojas">Vartotojas</option>
                        <option value="admin">Admin</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Registruotis</button>
                <p class="text-center mt-3">Jau turite prisijungimą? <a href="login.php">Prisijungti</a></p>
            </form>
        </div>
    </div>

</body>
</html>