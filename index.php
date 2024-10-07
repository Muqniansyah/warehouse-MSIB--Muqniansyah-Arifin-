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

// Tangkap pencarian dari parameter GET (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modifikasi query berdasarkan pencarian
if (!empty($search)) {
    // Query dengan filter pencarian
    $stmt = $datas->search($search);
} else {
    // Query default jika tidak ada pencarian yaitu membaca data data gudang
    $stmt = $datas->read();
}

$num = $stmt->rowCount(); // Menghitung jumlah data yang ditemukan.

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
    echo "<thead class='table-secondary'><tr><th>ID</th><th>Name</th><th>Location</th><th>Capacity</th><th>Status</th><th>Waktu Buka</th><th>Waktu Tutup</th><th>Aksi</th></tr></thead>";
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
        echo "<td>";
        echo "<a href='view-edit.php?id={$id}' class='btn btn-sm btn-secondary'><i class='bi bi-pencil'></i></a> ";
        echo "<a href='delete.php?id={$id}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'><i class='bi bi-trash'></i></a>";
        echo "</td>";
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