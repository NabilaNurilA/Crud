<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>CRUD System</title>
    <style>
        /* Basic styling */
        body {
            background-color: #AEC6CF;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 20px;
            background-color: #FFB6C1;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px; /* Space between search form and button */
            margin-bottom: 20px;
        }
        .search-form {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .btn, .btn-edit, .btn-delete {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 3px;
        }
        .btn {
            background-color: #4CAF50;
            display: inline-block;
        }
        .btn  {
            background-color: #4CAF50;
            display: inline-block;
        }

        .btn-logout {
            background-color: #f44336; /* Warna merah */
        }

        .btn-logout:hover {
            background-color: #d32f2f; /* Warna merah lebih gelap saat hover */
        }

        .btn-edit {
            background-color: #2196F3;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .table-container {
            margin-top: 20px;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:nth-child(odd) {
            background-color: #FFDFE5;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            list-style: none;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            color: black;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .pagination .active a {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>

        <!-- Search Form and Add Button -->
        <div class="form-container">
            <form method="GET" action="index.php" class="search-form">
                <input type="text" name="search" placeholder="Cari nama pengguna..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Cari</button>
                <a href="index.php" class="btn">Reset</a>                
                <a href="authentication/logout.php" class="btn btn-logout">Logout</a>              
            </form>

            <!-- Add Button below the search form -->
            <a href="create.php" class="btn">Tambah Pengguna Baru</a>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Set the number of records per page
                    $limit = 5;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Default SQL query
                    $sql = "SELECT * FROM pendaftar";
                    $count_sql = "SELECT COUNT(*) FROM pendaftar";

                    // Check if a search term is provided
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $conn->real_escape_string($_GET['search']);
                        $sql .= " WHERE name LIKE '%$search%'";
                        $count_sql .= " WHERE name LIKE '%$search%'";
                    }

                    // Pagination SQL query
                    $sql .= " LIMIT $limit OFFSET $offset";

                    // Execute the query
                    $result = $conn->query($sql);

                    // Display the results
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["id"]) . "</td>
                                    <td>" . htmlspecialchars($row["name"]) . "</td>
                                    <td>" . htmlspecialchars($row["email"]) . "</td>
                                    <td>" . htmlspecialchars($row["phone"]) . "</td>
                                    <td>
                                        <a href='update.php?id=" . htmlspecialchars($row["id"]) . "' class='btn-edit'>Edit</a>
                                        <a href='delete.php?id=" . htmlspecialchars($row["id"]) . "' class='btn-delete'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }

                    // Calculate total pages
                    $count_result = $conn->query($count_sql);
                    $total_records = $count_result->fetch_row()[0];
                    $total_pages = ceil($total_records / $limit);

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <ul class="pagination">
            <?php if($page > 1): ?>
                <li><a href="?page=<?php echo $page - 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Prev</a></li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <a href="?page=<?php echo $i; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if($page < $total_pages): ?>
                <li><a href="?page=<?php echo $page + 1; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
