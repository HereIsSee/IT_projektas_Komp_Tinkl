<?php
include('database_connection.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Center the form */
        .login-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Prisijungti</h2>
			<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$el_pastas = mysqli_real_escape_string($dbc, $_POST['el_pastas']);
				$slaptazodis = $_POST['slaptazodis'];

				$sql = "SELECT id, slaptazodis, vaidmuo, vardas FROM VARTOTOJAS WHERE el_pastas = '$el_pastas'";
				$result = mysqli_query($dbc, $sql);

				if (mysqli_num_rows($result) == 1) {
					$user = mysqli_fetch_assoc($result);

					if (password_verify($slaptazodis, $user['slaptazodis'])) {
						$_SESSION['user_id'] = $user['id'];
						$_SESSION['vaidmuo'] = $user['vaidmuo'];
						$_SESSION['vardas'] = $user['vardas'];
						echo "Login successful! Welcome, " . $user['vaidmuo'];
						// Redirect to another page if needed
						header("Location: dashboard.php");
						exit();
					} else {
						echo '<p style="color: red;">Incorrect password</p>';
					}
				} else {
					echo '<p style="color: red;">No account found with that email</p>';
				}
			}
			?>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>






