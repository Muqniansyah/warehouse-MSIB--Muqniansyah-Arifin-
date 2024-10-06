<?php
// import file
require_once 'connect.php';
require_once 'data.php';

// koneksi ke database
$database = new Database();
// buat objek baru dan simpan dalam variabel
$db = $database->getConnection();

// Membuat objek data gudang
$datas = new Datas($db);

// jika id bernilai true / id ada diurl maka akab disimpan dalam variabel datas->id
$datas->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
// jalankan method delete() 
$datas->delete();
// jalankan method reset_auto_increment()
$datas-> reset_auto_increment();

// kembali kehalaman index
header("Location: index.php");
// menghentikan eksekusi skrip
exit;
?>