<?php

include 'conn.php';
$nim = $_GET['nim'];

    $query = $conn->prepare("DELETE FROM mahasiswa WHERE nim = ?");
    $query->bind_param('s', $nim);

    if ($query->execute()) {
        header('Location: home.php');
    } else {
        echo "error: " . $query->error;
    }
?>