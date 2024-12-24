<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "crud_db");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek apakah form telah dikirim dengan metode GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $query = $_GET['query'];
    
    // Menyiapkan statement untuk mencari data
    $stmt = $conn->prepare("SELECT * FROM users WHERE name LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    
    // Eksekusi query dan cek hasilnya
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Menampilkan hasil pencarian
    if ($result->num_rows > 0) {
        echo "<h2>Hasil Pencarian untuk '$query':</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "Nama: " . $row["name"] . "<br>Email: " . $row["email"] . "<br>Telepon: " . $row["phone"] . "<hr>";
        }
    } else {
        echo "Tidak ada hasil untuk '$query'.";
    }
    
    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Pengguna</title>
</head>
<body>

<form method="GET" action="search.php">
    <label for="query">Cari Nama:</label>
    <input type="text" id="query" name="query" required>
    <button type="submit">Cari</button>
</form>

</body>
</html>
