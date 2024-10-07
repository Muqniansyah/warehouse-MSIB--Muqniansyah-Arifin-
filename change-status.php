<?php
require_once 'connect.php';
require_once 'data.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Membuat objek data gudang
$datas = new Datas($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan ID dan status dari POST
    $id = $_POST['id'];
    $current_status = $_POST['current_status'];

    // Tentukan status baru berdasarkan status saat ini
    $new_status = ($current_status === 'aktif') ? 'tidak_aktif' : 'aktif';

    // Mengatur id dan status baru pada objek data gudang
    $datas->id = $id;
    $datas->status = $new_status;

    // Perbarui status di database
    if ($datas->updateStatus()) {
        // Redirect kembali ke halaman utama setelah update berhasil
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengubah status.";
    }
}
