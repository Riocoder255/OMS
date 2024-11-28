<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

include ('./admin_connect.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Event ID is not specified.");
}

$id = intval($_GET['id']); // Convert to an integer for security


$sql = "SELECT * FROM events WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Check if the event exists
if (mysqli_num_rows($result) > 0) {
    $event = mysqli_fetch_assoc($result);
} else {
    die("Error: Event not found.");
}





// Handle fallback values for the form
$title = isset($event['title']) ? htmlspecialchars($event['title']) : '';
$desc = isset($event['description']) ? htmlspecialchars($event['description']):'';
$start = isset($event['start']) ? htmlspecialchars($event['start']) : '';
$end = isset($event['end']) ? htmlspecialchars($event['end']) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $start = mysqli_real_escape_string($conn, $_POST['start']);
    $end = mysqli_real_escape_string($conn, $_POST['end']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "UPDATE events SET title = '$title', start_date = '$start', end_date = '$end', description ='$desc' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Event updated successfully.";
    } else {
        echo "Error updating event: " . mysqli_error($conn);
    }
}
?>
<div class="container"style="margin-top:15%; margin-left:10%;">
<form method="POST" action="edit_event.php?id=<?= htmlspecialchars($id) ?>">
    <h2>Edit  Event </h2>
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <div class="row">
        <div class="col">
        <label>Title:</label>
        <input type="text" name="title" value="<?= $title ?>" class="form-control" style="width: 50%;">
        </div>
        <div class="col">
        <label>Description:</label>
        <input type="text" name="description" value="<?= $desc ?>"class="form-control"style="width: 50%;">
        </div>
    </div>
 <div class="row">
    <div class="col">
        
    <label>Start:</label>
    <input type="date" name="start" value="<?= date('Y-m-d', strtotime($start)) ?>"class="form-control"style="width: 50%;">
    </div>
    <div class="col">
    <label>End:</label>
    <input type="date" name="end" value="<?= date('Y-m-d', strtotime($end)) ?>"class="form-control"style="width: 50%;">
    </div>
 </div>
    <br>
    <button type="submit" class="btn btn-success">Update Event</button>
    <a href="./Calendar_event.php" class="btn btn-dark"> Back</a>
</form>
</div>
<?php 
include("./layouts/footer.php");
include("./layouts/scripts.php");

?>