<?php
require_once "./admin_connect.php";

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    $query = "SELECT * FROM item_order WHERE order_id = $order_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table">';
        echo '<thead><tr><th>Item</th><th>Quantity</th><th>Price</th></tr></thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . intval($row['quantity']) . '</td>';
            echo '<td>' . htmlspecialchars($row['price']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No item orders found for this order.</p>';
    }
} else {
    echo '<p>Invalid order ID.</p>';
}

mysqli_close($conn);
?>
