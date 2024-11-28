<?php
require_once "admin_connect.php";

if (isset($_GET['event_id'])) {
    $eventId = intval($_GET['event_id']);

    $query = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        echo json_encode($event);
    } else {
        echo json_encode(['error' => 'Event not found']);
    }
} else {
    echo json_encode(['error' => 'No event ID provided']);
}
?>
