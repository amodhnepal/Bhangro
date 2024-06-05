<?php include('../server/connection.php');?>

<?php  
// Fetch payment details from the database
$sql = "SELECT * FROM payments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Payment Details</title>
    <style>
        /* Internal CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin:   0;
            padding:   0;
        }
        .admin-table {
            width:   80%;
            margin:   50px auto;
            border-collapse: collapse;
        }
        .admin-table th,
        .admin-table td {
            padding:   10px;
            text-align: left;
            border-bottom:   1px solid #ddd;
        }
        .admin-table th {
            background-color: #4CAF50;
            color: white;
        }
        .admin-table tr:hover {background-color: #f5f5f5;}
    </style>
</head>
<body>
    <h1>Payment Details</h1>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Payment Mode</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows >  0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["payment_mode"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td><a href='change_status.php?id=" . $row["id"] . "'>Change Status</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No payments found.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
