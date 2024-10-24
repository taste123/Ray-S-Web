<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$admin = $user['username'] === 'adminxxx';
$users_data = $_SESSION['all_users_data'] ?? [];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- header -->
    <div class="headerText">
      <h3>Wellcome, <?= $user['name'] ?>!</h3>
    </div>

    <!-- admin -->
     <?php if ($admin):?>
    <h4>All users data</h4>
    <div class="dataTable">
      <table border="1">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Gender</th>
            <th>Faculty</th>
            <th>Batch</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users_data as $u): ?>
            <tr>
              <td><?= $u['name']; ?></td>
              <td><?= $u['email']; ?></td>
              <td><?= $u['username']; ?></td>
              <td><?= $u['gender']; ?></td>
              <td><?= $u['faculty']; ?></td>
              <td><?= $u['batch']; ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <!-- users -->
    <?php else: ?>
        <h3>User Information</h3>
        <div class="dataTable">
            <p><strong>Name:</strong> <?= $user['name']; ?></p>
            <p><strong>Email:</strong> <?= $user['email']; ?></p>
            <p><strong>Username:</strong> <?= $user['username']; ?></p>
            <p><strong>Gender:</strong> <?= $user['gender']; ?></p>
            <p><strong>Faculty:</strong> <?= $user['faculty']; ?></p>
            <p><strong>Batch:</strong> <?= $user['batch']; ?></p>
        </div>
    <?php endif; ?>
    <a href="logout.php"><button>Log Out</button></a>
  </body>
</html>
