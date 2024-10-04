SISTEM Warehouse MSIB

Database schema:
CREATE DATABASE warehouse_msib;

CREATE TABLE gudang (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,                   		 	(Nama gudang)
    location VARCHAR(255) NOT NULL,                 			(Lokasi gudang)
    capacity INT NOT NULL,                       				(Kapasitas maksimal gudang)
    status ENUM('aktif', 'tidak_aktif') DEFAULT 'aktif',  	(Status operasi gudang)
    opening_hour TIME,                                					(Waktu buka gudang)
    closing_hour TIME,                               					(Waktu tutup gudang)
);

Fitur Utama:
1.	Create: menambahkan Data Guiding baru
2.	Read: menampilkan list Gudang.
3.	Update: mengupdate Data Gudang.
4.	Delete: menghapus Data Gudang or merubahnya menjadi status tidak aktif.

note:
Implementasi CRUD Menggunakan PHP OOP
Pengumpulan Tugas diupload via Github OR google drive
Format nama file: warehouse-MSIB-[namaLengkap]