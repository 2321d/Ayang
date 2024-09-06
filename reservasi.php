<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Mengambil data pesanan yang ada
$sql = "SELECT * FROM pesanan WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare statement gagal: " . $conn->error);
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Pesanan tidak ditemukan.");
}

$pesanan = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            background-color: #333;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Pesanan</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($pesanan['id']); ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?php echo htmlspecialchars($pesanan['nama']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($pesanan['email']); ?></td>
            </tr>
            <tr>
                <th>Nomor Hp</th>
                <td><?php echo htmlspecialchars($pesanan['nomer']); ?></td>
            </tr>
            <tr>
                <th>Jenis Kopi</th>
                <td><?php echo htmlspecialchars($pesanan['jenis_kopi']); ?></td>
            </tr>
            <tr>
                <th>Ukuran</th>
                <td><?php echo htmlspecialchars($pesanan['ukuran']); ?></td>
            </tr>
            <tr>
                <th>Toping Tambahan</th>
                <td><?php echo htmlspecialchars($pesanan['toping_tambahan']); ?></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td><?php echo htmlspecialchars($pesanan['jumlah']); ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo nl2br(htmlspecialchars($pesanan['alamat'])); ?></td>
            </tr>
            <tr>
                <th>Tanggal Pesan</th>
                <td><?php echo htmlspecialchars($pesanan['tanggal_pesan']); ?></td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td><?php echo number_format($pesanan['total_harga'], 0, ',', '.') . " IDR"; ?></td>
            </tr>
        </table>
        <button onclick="confirmOrder()" class="btn">Konfirmasi Pemesanan</button>
        <a href="edit.php?id=<?php echo htmlspecialchars($pesanan['id']); ?>" class="btn">Edit</a>
    </div>
    <script>
        function confirmOrder() {
            if (confirm("Apakah Anda yakin ingin memesan?")) {
                alert("Terima kasih atas pesanan Anda!");
                window.location.href = "index.html";
            }
        }
    </script>
</body>
</html>

