<?php
// import file
require_once 'connect.php';
require_once 'data.php';

// Koneksi ke database
$database = new Database();
// buat objek baru dan simpan dalam variabel
$db = $database->getConnection();

// Membuat objek data gudang
$datas = new Datas($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datas->name = $_POST['name'];
    $datas->location = $_POST['location'];
    $datas->capacity = $_POST['capacity'];
    $datas->status = $_POST['status'];
    $datas->waktu_buka = $_POST['waktu_buka'];
    $datas->waktu_tutup = $_POST['waktu_tutup'];
    
    if ($datas->create()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambah data gudang.";
    }
}

// Mulai buffering keluaran untuk menangkap konten
ob_start();
?>

<h1 class="text-center">Add Warehouse Data</h1>

<form action="view-create.php" method="POST">
    <div class="mb-3">
        <label for="name">Name :</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="mb-3">
        <label for="location">Location :</label>
        <input type="text" class="form-control" name="location" id="location" required>
    </div>

    <div class="mb-3">
        <label for="capacity">Capacity :</label>
        <input type="text" class="form-control" name="capacity" id="capacity" required>
    </div>

    <div class="mb-3">
        <label for="status">Status :</label>
        <select class="form-select" name="status" id="status" required>
            <option value="" disabled selected>Pilih Status</option>
            <option value="aktif">Aktif</option>
            <option value="tidak_aktif">Tidak Aktif</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="waktu_buka">Waktu Buka :</label>
        <input type="time" class="form-control" name="waktu_buka" id="waktu_buka" required>
    </div>

    <div class="mb-3">
        <label for="waktu_tutup">Waktu Tutup :</label>
        <input type="time" class="form-control" name="waktu_tutup" id="waktu_tutup" required>
    </div>

    <input type="submit" class="btn btn-dark w-100" value="Add New Data">
</form>


<?php
    // Tangkap konten untuk tata letak
    $content = ob_get_clean();

    // Sertakan templat tata letak dan teruskan kontennya
    include 'layout.php';
?>


