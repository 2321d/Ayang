<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$nama = isset($_POST['nama']) ? $conn->real_escape_string($_POST['nama']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$nomer = isset($_POST['nomer']) ? $conn->real_escape_string($_POST['nomer']) : '';
$jenis_kopi = isset($_POST['jenis_kopi']) ? $conn->real_escape_string($_POST['jenis_kopi']) : '';
$ukuran = isset($_POST['ukuran']) ? $conn->real_escape_string($_POST['ukuran']) : '';
$toping_tambahan = isset($_POST['toping_tambahan']) ? $conn->real_escape_string($_POST['toping_tambahan']) : '';
$jumlah = isset($_POST['jumlah']) ? $conn->real_escape_string($_POST['jumlah']) : '';
$alamat = isset($_POST['alamat']) ? $conn->real_escape_string($_POST['alamat']) : '';
$tanggal_pesan = isset($_POST['tanggal_pesan']) ? $conn->real_escape_string($_POST['tanggal_pesan']) : '';
$harga_kopi = array(
    'espresso'=> 20000,
    'latte' => 22000,
    'cappuccino' => 25000,
    'americano' => 18000
);
$harga_ukuran = array(
    'kecil' => 10000,
    'sedang' => 15000,
    'besar' => 20000
);
$harga_toping = array(
    'sugar' => 5000,
    'milk' => 5000,
    'whipped-cream' => 5000
);
$total_keseluruhan = $harga_kopi[$jenis_kopi] + $harga_ukuran[$ukuran] + $harga_toping[$toping_tambahan];
$total_harga = $total_keseluruhan * $jumlah;
$sql = "INSERT INTO pesanan (nama, email, nomer, jenis_kopi, ukuran, toping_tambahan, jumlah, alamat, tanggal_pesan, total_harga) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$tanggal_pesan = date('Y-m-d H:i:s');
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare statement gagal: " . $conn->error);
}$stmt->bind_param('sssssssssi', $nama, $email, $nomer, $jenis_kopi, $ukuran, $toping_tambahan, $jumlah, $alamat, $tanggal_pesan, $total_harga);

if ($stmt->execute()) {
    $last_id = $conn->insert_id;
    header("Location: reservasi.php?id=$last_id");
    exit();
} else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
}
$stmt->close();
$conn->close();
?>
