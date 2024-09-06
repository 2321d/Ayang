<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM pesanan WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare statement gagal: " . $conn->error);
    }

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Pesanan telah dihapus'); window.location.href = 'tampil.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'tampil.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak valid'); window.location.href = 'tampil.php';</script>";
}

$conn->close();
?>
