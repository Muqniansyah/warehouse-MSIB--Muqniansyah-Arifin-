<?php
class Database {
    private $host = "localhost"; // nama host
    private $db_name = "warehouse_msib"; // nama database
    private $username = "root"; // username MYSQL
    private $password = ""; // password MYSQL
    public $conn; // untuk simpan koneksi database

    // mendapatkan koneksi 
    public function getConnection() {
        $this -> conn = null;

        try {
            // membuat koneksi dengan PDO
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);

            // mengatur karakter set agar menggunakan utf8
            $this->conn->exec("set names utf8");
        } catch (\Throwable $err) {
            // error handling jika gagal terhubung ke database
            echo "Connection failed: " . $err->getMessage();
        }

        // mengembalikkan objek koneksi
        return $this->conn;
    }

}

// membuat objek baru 
$database = new Database();
// memanggil method getConnection
$database -> getConnection();
?>