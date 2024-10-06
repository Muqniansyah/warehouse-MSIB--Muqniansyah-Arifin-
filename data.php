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

    // membaca data dari database
    public function read(){
        $stmt = $this->conn->prepare("SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM ". $this->table_name);
        $stmt->execute();

        return $stmt;
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

    // mengahpus data berdasarkan id 
    public function delete(){
        $stmt = $this->conn->prepare("DELETE FROM ". $this->table_name ." WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        
        // jika berhasil dijalankan
        if ($stmt->execute()) {
            return true;
        }   

        // jika gagal dijalankan
        return false;
    }

    // reset auto increment
    public function reset_auto_increment() {
        // Atur ulang id dan auto increment
        // gunakan exec() untuk query yang tidak membutuhkan hasil return.
        $this->conn->exec("SET @num := 0;");
        $this->conn->exec("UPDATE $this->table_name SET id = @num := (@num+1);");
        $this->conn->exec("ALTER TABLE $this->table_name AUTO_INCREMENT = 1;");
    } 

    // memperbarui data gudang berdasarkan id
    public function update(){
        // mengubah kolom berdasarkan id tertentu
        $stmt = $this->conn->prepare("UPDATE ". $this->table_name ." SET name=:name, location=:location, capacity=:capacity, status=:status, opening_hour=:opening_hour, closing_hour=:closing_hour WHERE id=:id");
        
        // mengikat nilai dari objek class/objek yang dibuat dari sebuah class
        $stmt->bindParam(":id", $this->id);
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

    // untuk mendapatkan data dari database berdasarkan id tertentu.
    public function show($id){
        // mengambil data dengan id
        $stmt = $this->conn->prepare("SELECT id, name, location, capacity, status, opening_hour, closing_hour FROM ". $this->table_name ." WHERE id=:id");
        
        // mengikat parameter id dengan nilai yang diberikan dan dijalankan/eksekusi dengan execute()
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt;
    }
}
?>