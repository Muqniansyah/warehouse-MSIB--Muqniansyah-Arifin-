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

// Tentukan jumlah data per halaman
$records_per_page = 5;

// Tentukan halaman saat ini (default ke halaman 1 jika tidak ada parameter 'page')
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Validasi halaman
if ($page < 1) {
    $page = 1; // Jika halaman kurang dari 1, set ke 1
}

// Hitung offset
$offset = ($page - 1) * $records_per_page;

// Query untuk menghitung total jumlah data
$total_records_query = $db->query("SELECT COUNT(*) FROM gudang");
$total_records = $total_records_query->fetchColumn();

// Hitung jumlah total halaman
$total_pages = ceil($total_records / $records_per_page);

// Query untuk mengambil data sesuai dengan pagination
$query = "SELECT * FROM gudang LIMIT :offset, :records_per_page"; // Ubah bagian ini
$stmt = $db->prepare($query);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

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
        
        // Form untuk ubah status
        echo "<form action='change-status.php' method='post' style='display:inline-block;'>";
        echo "<input type='hidden' name='id' value='{$id}'>";
        echo "<input type='hidden' name='current_status' value='{$status}'>";  // Kirim status saat ini
        echo "<button type='submit' class='btn btn-sm btn-dark ms-2'>";
        echo ($status === 'aktif') ? 'tidak_aktif' : 'aktif';  // Ubah teks tombol berdasarkan status
        echo "</button>";
        echo "</form>";
        
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    // Menampilkan pagination
    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination justify-content-center">';

    // Tombol Previous
    echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '">';
    echo '<a class="page-link" href="?page=' . ($page - 1) . '">Previous</a>';
    echo '</li>';

    // Link ke setiap halaman
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
        echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
        echo '</li>';
    }

    // Tombol Next
    echo '<li class="page-item ' . ($page >= $total_pages ? 'disabled' : '') . '">';
    echo '<a class="page-link" href="?page=' . ($page + 1) . '">Next</a>';
    echo '</li>';

    echo '</ul>';
    echo '</nav>';
} else {
    echo "<p class='alert alert-info'>Tidak ada data pelanggan.</p>";
}

// Tangkap konten untuk tata letak
$content = ob_get_clean();

// Sertakan templat tata letak dan teruskan kontennya
include 'layout.php';
?>