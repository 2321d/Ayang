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
    <title>Edit Pesanan</title>
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 0.5rem;
        }
        input, select, textarea {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #333;
            color: #fff;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Pesanan</h2>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($pesanan['id']); ?>">

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pesanan['nama']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pesanan['email']); ?>" required>

            <label for="nomer">Nomor Hp</label>
            <input type="text" id="nomer" name="nomer" value="<?php echo htmlspecialchars($pesanan['nomer']); ?>" required>

            <label for="jenis_kopi">Jenis Kopi</label>
            <select id="jenis_kopi" name="jenis_kopi" required>
                <option value="espresso" <?php echo $pesanan['jenis_kopi'] === 'espresso' ? 'selected' : ''; ?>>Espresso</option>
                <option value="latte" <?php echo $pesanan['jenis_kopi'] === 'latte' ? 'selected' : ''; ?>>Latte</option>
                <option value="cappuccino" <?php echo $pesanan['jenis_kopi'] === 'cappuccino' ? 'selected' : ''; ?>>Cappuccino</option>
                <option value="americano" <?php echo $pesanan['jenis_kopi'] === 'americano' ? 'selected' : ''; ?>>Americano</option>
            </select>

            <label for="ukuran">Ukuran</label>
            <select id="ukuran" name="ukuran" required>
                <option value="kecil" <?php echo $pesanan['ukuran'] === 'kecil' ? 'selected' : ''; ?>>Kecil</option>
                <option value="sedang" <?php echo $pesanan['ukuran'] === 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                <option value="besar" <?php echo $pesanan['ukuran'] === 'besar' ? 'selected' : ''; ?>>Besar</option>
            </select>

            <label for="toping_tambahan">Toping Tambahan</label>
            <select id="toping_tambahan" name="toping_tambahan" required>
                <option value="sugar" <?php echo $pesanan['toping_tambahan'] === 'sugar' ? 'selected' : ''; ?>>Sugar</option>
                <option value="milk" <?php echo $pesanan['toping_tambahan'] === 'milk' ? 'selected' : ''; ?>>Milk</option>
                <option value="whipped-cream" <?php echo $pesanan['toping_tambahan'] === 'whipped-cream' ? 'selected' : ''; ?>>Whipped Cream</option>
            </select>

            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($pesanan['jumlah']); ?>" required>

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="4" required><?php echo htmlspecialchars($pesanan['alamat']); ?></textarea>

            <label for="tanggal_pesan">Tanggal Pesan</label>
            <input type="datetime-local" id="tanggal_pesan" name="tanggal_pesan" value="<?php echo htmlspecialchars($pesanan['tanggal_pesan']); ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
