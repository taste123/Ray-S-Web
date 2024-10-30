<?php
session_start();
echo $_SESSION['nim'];
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit;
}
echo "aaa";
$nim = $_SESSION['nim'];
$admin = $nim === '001';

include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            margin-bottom: 20px; 
        }

        th, td { 
            padding: 10px; 
            text-align: left; 
            border: 1px solid #ddd;
            background-color: #C7B7A3;
            color: #561C24;
        }

        th { 
            background-color: #6D2932; 
            color: #C7B7A3;
        }

        .homeBody {
            height: 75vh;
        }

        .homeButton {
            background-color: #C7B7A3;
            color: #561C24;
        }

        .homeButton:hover {
            background-color: #d2c5b2;
        }

    </style>
</head>
<body class="homeBody">
    <?php if ($admin): ?>
        <div class="headerText">
            <h3>Dashboard Admin</h3>
        </div>
    <table>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Password</th>
            <th>Edit</th>
        </tr>
        <?php
        $query = "SELECT * FROM mahasiswa";
        $data_mahasiswa = $conn->query($query);

        while ($row = $data_mahasiswa->fetch_assoc()) {
            $nama = htmlspecialchars($row['nama']);
            $nim = htmlspecialchars($row['nim']);
            $prodi = htmlspecialchars($row['prodi']);
            $pass_display = str_repeat('*', 8);
        ?>
        <tr>
            <td><?= $nama; ?></td>
            <td><?= $nim; ?></td>
            <td><?= $prodi; ?></td>
            <td><?= $pass_display; ?></td>
            <td>
                <a href="edit.php?nim=<?= $nim; ?>"><button>Edit</button></a> 
                <a href="proses_hapus.php?nim=<?= $nim; ?>"><button>Delete</button></a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div class="buttonAdminDiv">
        <div class="buttonAdmin">
            <a href="input.php"><button class="homeButton">Add Data</button></a>
        </div>
    <?php else: ?>  
        <?php
        $stmt = $conn->prepare("SELECT nama, nim, prodi FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $nama = $user_data['nama'];
            $prodi = $user_data['prodi'];
        ?>
            <h2>Welcome, <?= $nama; ?></h2>
            <p><strong>NIM:</strong> <?= $nim; ?></p>
            <p><strong>Prodi:</strong> <?= $prodi; ?></p>
        <?php } else { ?>
            <p>User data not found.</p>
        <?php }
        $stmt->close();
        ?>
    <?php endif; ?>
    <div class="buttonAdmin">
        <a href="logout.php"><button class="homeButton">Log Out</button></a>
    </div>
</div>
</body>
</html>
