<?php
$conn = new mysqli("localhost", "root", "", "crud_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pendaftar WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE pendaftar SET name='$name', email='$email', phone='$phone' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <style>
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
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label>Nama:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    <label>Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    <label>Telepon:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
    <button type="submit">Update</button>
</form>

</body>
</html>
