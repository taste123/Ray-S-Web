<?php
session_start();

$users = [
  [
     'email' => 'admin@gmail.com',
     'username' => 'adminxxx',
     'name' => 'Admin',
     'password' => password_hash('admin123', PASSWORD_DEFAULT),
 ],
 [
     'email' => 'nanda@gmail.com',
     'username' => 'nanda_aja',
     'name' => 'Wd. Ananda Lesmono',
     'password' => password_hash('nanda123', PASSWORD_DEFAULT),
     'gender' => 'Female',
     'faculty' => 'MIPA',
     'batch' => '2021',
 ],
 [
     'email' => 'arif@gmail.com',
     'username' => 'arif_nich',
     'name' => 'Muhammad Arief',
     'password' => password_hash('arief123', PASSWORD_DEFAULT),
     'gender' => 'Male',
     'faculty' => 'Hukum',
     'batch' => '2021',
 ],
 [
  'email' => 'eka@gmail.com',
  'username' => 'eka59',
  'name' => 'Eka Hanny',
  'password' => password_hash('eka123', PASSWORD_DEFAULT),
  'gender' => 'Female',
  'faculty' => 'Keperawatan',
  'batch' => '2021',
],
[
  'email' => 'adnan@gmail.com',
  'username' => 'adnan72',
  'name' => 'Adnan',
  'password' => password_hash('adnan123', PASSWORD_DEFAULT),
  'gender' => 'Male',
  'faculty' => 'Teknik',
  'batch' => '2020',
],
];

$error_message = '';

if ($_SERVER['REQUEST_METHOD']=='POST') {
  $inputEmailUsername = $_POST['emailORusername'];
  $inputPassword = $_POST['password'];

  foreach ($users as $user) {
    if ($user['email'] === $inputEmailUsername || $user['username'] === $inputEmailUsername && password_verify($inputPassword,$user['password'])) {
      $_SESSION['logged_in'] = true;
      $_SESSION['user'] = $user;
      $_SESSION['all_users_data'] = $users;

      header('Location: dashboard.php');
      exit();
    }
  }
  $error_message = "Invalid username/email or password";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>login</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- header -->
    <div class="headerText">
      <h3>Login</h3>
    </div>
    <?php if ($error_message): ?>
      <div class="error"><?= $error_message; ?></div>
      <?php endif; ?>

    <div class="form">
      <form method="POST">
        <div class="formGroup">
          <input
            type="text"
            name="emailORusername"
            placeholder="Email or Username"
            required
          />
        </div>
        <div class="formGroup">
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </body>
</html>
