<?php
class Datas {
    private $conn;
    private $table_name = "gudang";

    public $id;
    public $name;
    public $location;
    public $capacity;
    public $status;
    public $waktu_buka;
    public $waktu_tutup;

    // constructor untuk inisialisasi property
    public function __construct($db) {
        $this ->conn = $db;
    }

    //  menambahkan data ke database
    public function create(){
        // memasukkan nilai kedalam tabel
        $stmt = $this->conn->prepare("INSERT INTO ". $this->table_name ." (name, location, capacity, status, opening_hour, closing_hour) VALUES (:name, :location, :capacity, :status, :opening_hour, :closing_hour)");

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->waktu_buka);
        $stmt->bindParam(":closing_hour", $this->waktu_tutup);
        
        // jika berhasil dijalankan
        if ($stmt->execute()) {
            return true;
        }

        // jika gagal dijalankan
        return false;

    }

    // membaca data dari database
    public function read(){
        $stmt = $this->conn->prepare("SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM ". $this->table_name);
        $stmt->execute();

        return $stmt;
    }

    
}

?>