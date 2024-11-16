<?php
include('database_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the form */
        .register-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2>Registruotis</h2>
			<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$vardas = mysqli_real_escape_string($dbc, $_POST['vardas']);
				$el_pastas = mysqli_real_escape_string($dbc, $_POST['el_pastas']);
				$slaptazodis = password_hash($_POST['slaptazodis'], PASSWORD_DEFAULT);
				$role = mysqli_real_escape_string($dbc, $_POST['role']);

				$check_query = "SELECT * FROM VARTOTOJAS WHERE vardas = ? OR el_pastas = ?";
                $stmt = $dbc->prepare($check_query);
                $stmt->bind_param("ss", $vardas, $el_pastas);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows > 0) {
                    echo "<h2>Error: Username or email already exists.</h2>";
                } else{
                    $sql = "INSERT INTO VARTOTOJAS (vardas, el_pastas, slaptazodis, vaidmuo) VALUES (?, ?, ?, ?)";
                    $stmt = $dbc->prepare($sql);
                    $stmt->bind_param("ssss", $vardas, $el_pastas, $slaptazodis, $role);
                    
                    if ($stmt->execute()) {
                        echo "<h2>Sėkminga registracija!</h2>";
                    } else {
                        echo "<h2>Error: " . $dbc->error . "</h2>";
                    }
                }
				
			}
			?>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
