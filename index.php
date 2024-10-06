<?php
// import file
require_once 'connect.php';
require_once 'data.php';

// koneksi ke database
$database = new Database();
// buat objek baru dan simpan dalam variabel
$db = $database -> getConnection();

// Membuat objek data gudang
$datas = new Datas($db);

// Membaca data data gudang
$stmt = $datas->read();
$num = $stmt->rowCount(); // mengembalikan jumlah baris yang dikembalikan oleh query (banyak data yang ditemukan).

// contoh data dynamic
$title = "Daftar Pelanggan";

// Mulai buffering keluaran untuk menangkap konten
ob_start();
?>

<h1 class="text-center">Warehouse Data List</h1>

<?php
// Assuming you already have $stmt from your query
if ($num > 0) {
    echo "<table class='table table-bordered'>";
    echo "<thead class='table-dark'><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Aksi</th><th>Waktu Buka</th><th>Waktu Tutup</th></tr></thead>";
    echo "<tbody>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        //berdasarkan nama field database mysql
        echo "<td>{$id}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$location}</td>";
        echo "<td>{$capacity}</td>";
        echo "<td>{$status}</td>";
        echo "<td>{$opening_hour}</td>"; 
        echo "<td>{$closing_hour}</td>"; 
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='alert alert-info'>Tidak ada data pelanggan.</p>";
}

// Tangkap konten untuk tata letak
$content = ob_get_clean();

// Sertakan templat tata letak dan teruskan kontennya
include 'layout.php';
?>

