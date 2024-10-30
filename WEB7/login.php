<?php
session_start();
include 'conn.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nim = trim($_POST['nim']);
    $password = trim($_POST['pass']);
    
    // Check if NIM and password are filled
    if (empty($nim) || empty($password)) {
        $error_message = "NIM and Password are required.";
    } else {
        // Prepare SQL statement to select the user
        $stmt = $conn->prepare("SELECT nim, pass, nama FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            // Check if user exists
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($db_nim, $db_password, $nama);
                $stmt->fetch();
                
                // Verify password
                if (password_verify($password, $db_password)) {
                    // Set session variables and redirect to home
                    // $_SESSION['logged_in'] = true;
                    $_SESSION['nim'] = $db_nim;
                    $_SESSION['nama'] = $nama;
                    header("Location: home.php");
                    exit;
                } else {
                    $error_message = "Incorrect password.";
                }
            } else {
                $error_message = "NIM not found.";
            }
        } else {
            $error_message = "Error executing query: " . $stmt->error;
        }
        
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        a {
            text-decoration: none;
        }
        .button-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #6D2932;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-size: 12px;
        }

        .button-link:hover {
            background-color: #4a0b13;
        }

        .loginButtonDiv {
            display: flex;
            justify-content: space-evenly;
        }

    </style>
  </head>
  <body>
    <!-- header -->
    <div class="headerText">
      <h3>Login</h3>
    </div>

    <!-- Display error message if login fails -->
    <?php if (!empty($error_message)): ?>
      <div class="error"><?= htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="form">
      <form method="POST">
        <div class="formGroup">
          <input
            type="text"
            name="nim"
            placeholder="NIM"
            required
          />
        </div>
        <div class="formGroup">
          <input
            type="password"
            name="pass"
            placeholder="Password"
            required
          />
        </div>
        <div class="loginButtonDiv">
            <div class="loginButton">
                <button type="submit">Login</button>
            </div>
            <div class="loginButton">
                <a href="input.php" class="button-link">Registration</a>
            </div>
        </div>
      </form>
    </div>
  </body>
</html>
