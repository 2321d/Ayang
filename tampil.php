<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kopi";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$sql = "SELECT * FROM pesanan";
$result = $conn->query($sql);
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #f5f5f5; 
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            background: #fff; 
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #d2b89a; 
        }
        h2 {
            color: #3e2723; 
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #d2b89a; 
        }
        th {
            background-color: #d8cfc4; 
            color: #3e2723; 
        }
        tr:nth-child(even) {
            background-color: #fef8f3; 
        }
        .btn {
            background-color: #6f4e37; 
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn:hover {
            background-color: #4e3a26; 
        }
        .btn-delete {
            background-color: #c62828; 
        }
        .btn-delete:hover {
            background-color: #b71c1c; 
        }
        .btn-confirm {
            background-color: #388e3c; 
        }
        .btn-confirm:hover {
            background-color: #2c6b2f; 
        }
        .confirm-dialog {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 1rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border: 1px solid #d2b89a; 
        }
        .confirm-dialog p {
            margin: 0 0 1rem;
            color: #3e2723; 
        }
        .confirm-dialog button {
            margin-right: 0.5rem;
        }
        .confirm-dialog .btn {
            margin: 0;
        }
    </style>
    <script>
        function confirmDeletion(url) {
            const dialog = document.getElementById('confirm-dialog');
            const confirmBtn = document.getElementById('confirm-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            dialog.style.display = 'block';
            confirmBtn.onclick = () => {
                window.location.href = url;
            };
            cancelBtn.onclick = () => {
                dialog.style.display = 'none';
            };
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Daftar Seluruh Pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor Hp</th>
                    <th>Jenis Kopi</th>
                    <th>Ukuran</th>
                    <th>Toping Tambahan</th>
                    <th>Jumlah</th>
                    <th>Alamat</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nomer']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_kopi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ukuran']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['toping_tambahan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['alamat'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_pesan']) . "</td>";
                    echo "<td>" . number_format($row['total_harga'], 0, ',', '.') . " IDR</td>";
                    echo "<td><button onclick=\"confirmDeletion('hapus.php?id=" . urlencode($row['id']) . "')\" class='btn btn-delete'>Hapus</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        <a href="index.html" class="btn">Kembali ke Beranda</a>
    </div>
    <div id="confirm-dialog" class="confirm-dialog">
        <p>Apakah Anda yakin ingin menghapus pesanan ini?</p>
        <button id="confirm-btn" class="btn btn-confirm">Ya, Hapus</button>
        <button id="cancel-btn" class="btn">Batal</button>
    </div>
</body>
</html>
<?php
$conn->close();
?>
