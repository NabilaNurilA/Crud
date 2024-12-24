<?php
// Memastikan bahwa parameter 'id' ada dalam URL
if (isset($_GET['id'])) {
    // Mengambil 'id' dari URL dan melakukan sanitasi
    $id = intval($_GET['id']); // Mengubah menjadi integer untuk keamanan

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "crud_db");

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyiapkan pernyataan SQL untuk menghapus pengguna berdasarkan id
    $sql = "DELETE FROM users WHERE id = ?";

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Mengeksekusi query dan memeriksa hasilnya
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman utama
        header("Location: index.php");
        exit(); // Menghentikan eksekusi script setelah redirect
    } else {
        // Jika gagal, menampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Menutup koneksi dan statement
    $stmt->close();
    $conn->close();
} else {
    // Jika 'id' tidak ditemukan, redirect ke halaman utama
    header("Location: index.php");
    exit();
}
?>
