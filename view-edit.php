<?php
require_once 'connect.php';
require_once 'data.php';

// Koneksi ke database
$database = new Database();
// buat objek baru dan simpan dalam variabel
$db = $database->getConnection();

// Membuat objek data gudang
$datas = new Datas($db);

// Mendapatkan ID data gudang dari URL
$datas->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID tidak ditemukan.');

// dijalankan saat ada form yang dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datas->name = $_POST['name'];
    $datas->location = $_POST['location'];
    $datas->capacity = $_POST['capacity'];
    $datas->status = $_POST['status'];
    $datas->waktu_buka = $_POST['waktu_buka'];
    $datas->waktu_tutup = $_POST['waktu_tutup'];
    
    if ($datas->update()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate data gudang.";
    }
} else {
    // Jika request bukan POST, maka akan mendapatkan data gudang berdasarkan ID
    $stmt = $datas->show($datas->id);
    // mengambil hasil dari objek PDOStatement dalam bentuk array asosiatif.
    $result = $stmt->fetch(PDO::FETCH_ASSOC); 

    // memasukkan data dari array asosiatif $result ke dalam properti objek $datas
    $datas->name = $result['name'];
    $datas->location = $result['location'];
    $datas->capacity = $result['capacity'];
    $datas->status = $result['status'];
    $datas->waktu_buka = $result['opening_hour'];
    $datas->waktu_tutup = $result['closing_hour'];
}

// Mulai buffering keluaran untuk menangkap konten
ob_start();
?>

<h1 class="text-center">Edit Warehouse Data</h1>

<form action="view-edit.php?id=<?php echo $datas->id; ?>" method="POST">
    <div class="mb-3">
        <label for="name">Name :</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $datas->name; ?>" required>
    </div>

    <div class="mb-3">
        <label for="location">Location :</label>
        <input type="text" class="form-control" name="location" id="location" value="<?php echo $datas->location; ?>" required>
    </div>

    <div class="mb-3">
        <label for="capacity">Capacity :</label>
        <input type="text" class="form-control" name="capacity" id="capacity" value="<?php echo $datas->capacity; ?>" required>
    </div>

    <div class="mb-3">
        <label for="status">Status :</label>
        <select class="form-select" name="status" id="status" required>
            <option value="" disabled <?php echo empty($datas->status) ? 'selected' : ''; ?>>Pilih Status</option>
            <option value="aktif" <?php echo ($datas->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
            <option value="tidak_aktif" <?php echo ($datas->status == 'tidak_aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="waktu_buka">Waktu Buka :</label>
        <input type="time" class="form-control" name="waktu_buka" id="waktu_buka" value="<?php echo $datas->waktu_buka; ?>" required>
    </div>

    <div class="mb-3">
        <label for="waktu_tutup">Waktu Tutup :</label>
        <input type="time" class="form-control" name="waktu_tutup" id="waktu_tutup" value="<?php echo $datas->waktu_tutup; ?>" required>
    </div>

    <input type="submit" class="btn btn-secondary w-100" value="Update Data">
</form>

<?php
    // Tangkap konten untuk tata letak
    $content = ob_get_clean();

    // Sertakan templat tata letak dan teruskan kontennya
    include 'layout.php';
?>