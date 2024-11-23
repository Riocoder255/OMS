<?php
session_start();
include './admin_connect.php';


$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$salesData = [];

if ($startDate && $endDate) {
    $query = "SELECT o.id, o.date AS order_date, c.firstname, c.email, o.total_amount
              FROM orders o
              JOIN customer_info c ON o.customer_id = c.id
              WHERE o.payment_status = 'complete'
              AND o.date BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $salesData = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
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
    </style>
</head>
<body>
    <h1 class="text-success">Chantong Enterprise</h1>
    <h2>Sales Report for Date Range: <?php echo htmlspecialchars($startDate) . ' to ' . htmlspecialchars($endDate); ?></h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($salesData)): ?>
                <?php 
                $totalSales = 0;
                $totalOrders = count($salesData);
                foreach ($salesData as $data): 
                    $totalSales += $data['total_amount'];
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['id']); ?></td>
                        <td><?php echo htmlspecialchars($data['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($data['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($data['email']); ?></td>
                        <td><?php echo '₱' . number_format($data['total_amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4"><strong>Total Orders:</strong></td>
                    <td><strong><?php echo $totalOrders; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Total Sales:</strong></td>
                    <td><strong><?php echo '₱' . number_format($totalSales, 2); ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5">No records found for the specified date range.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p><a href="sales.php">Back to Generate Report</a></p>
</body>
</html>
