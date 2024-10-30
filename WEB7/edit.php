<?php
include 'conn.php';

// Get the NIM from the query parameter and fetch the data
$nim = $_GET['nim'];
$query = $conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$query->bind_param('s', $nim);
$query->execute();
$data_mahasiswa = $query->get_result();
$result = $data_mahasiswa->fetch_assoc();
$query->close();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $prodi = $_POST['prodi'];
    $pass = $_POST['pass'];
    $nim_lama = $_POST['nim_lama'];
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    // Prepare the update query
    $query = $conn->prepare("UPDATE mahasiswa SET nama = ?, nim = ?, prodi = ?, pass = ? WHERE nim = ?");
    $query->bind_param('sssss', $nama, $nim, $prodi, $hashed_password, $nim_lama);
    
    if ($query->execute()) {
        $query->close();
        $conn->close();
        header('Location: home.php');
        exit;
    } else {
        echo "Error: " . $query->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .formGroup {
            color: #561C24;
        }
    </style>
</head>
<body>
<div class="headerText">
    <h3>Edit</h3>
</div>
    <div class="form">
        <form action="edit.php?nim=<?= $nim ?>" method="post">
            <div class="formGroup">
                <label for="nama">Nama</label>
                <input type="text" name="nama" value="<?=$result['nama'] ?>" required>
                <br>
            </div>
            
            <div class="formGroup">
                <label for="nim">NIM</label>
                <input type="text" name="nim" value="<?=$result['nim'] ?>" required>
                <br>
            </div>
            
            <div class="formGroup">
                <label for="prodi">Prodi</label>
                <input type="text" name="prodi" value="<?=$result['prodi'] ?>" required>
                <br>
            </div>
            
            <div class="formGroup">
                <label for="pass">Password</label>
                <input type="text" name="pass" placeholder="Enter new password" required>
                <br>
            </div>
            
            <input type="hidden" name="nim_lama" value="<?=$result['nim'] ?>">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
