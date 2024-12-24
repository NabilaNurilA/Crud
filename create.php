<?php
// Mengecek apakah form telah dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = substr(preg_replace("/[^0-9]/", "", $_POST["phone"]), 0, 13);

    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "crud_db");

    // Mengecek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Menyiapkan statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan";
        header("Refresh: 2; URL=index.php"); // Redirect to index.php after 2 seconds
    } else {
        echo "Error: " . $stmt->error;
        header("Refresh: 2; URL=index.php"); // Redirect to index.php after 2 seconds
    }
    // Menutup koneksi dan statement
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengguna</title>
    <style>
        /* Mengatur gaya umum untuk body */
        body {
            font-family: Arial, sans-serif;
            background-color: #AEC6CF; /* Baby blue background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Mengatur gaya container form */
        form {
            background-color: #FFB6C1; /* Baby pink background for form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        /* Mengatur label input dan spasi antar elemen */
        form label {
            display: block;
            width: 100%;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Mengatur gaya tombol submit */
        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Mengatur gaya tombol submit saat di-hover */
        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <label>Nama:</label>
    <input type="text" name="name" required><br>
    <label>Email:</label>
    <input type="text" name="email" required><br>
    <label>Telepon:</label>
    <input type="text" name="phone" required><br>
    <button type="submit">Simpan</button>
</form>

</body>
</html>
