<?php
include('./admin_connect.php'); // Database connection
include('./layouts/header.php');
include('./layouts/sidebar.php');
include('./layouts/topbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
</head>
<body>
<?php
// Fetch feedback data from the database
$query = " 
    SELECT DISTINCT
        feedback.id, 
        feedback.rating, 
        feedback.comment, 
        feedback.created_at, 
        customer.name,
        GROUP_CONCAT(DISTINCT feedback_images.image_path SEPARATOR ',') AS images
    FROM 
        feedback
    LEFT JOIN 
        feedback_images ON feedback.id = feedback_images.feedback_id
    JOIN 
        customer ON customer.user_id = feedback.user_id
    GROUP BY 
        feedback.id
";

$result = mysqli_query($conn, $query);
?>
<div class="container mt-5">
    <h3 class="text-center">View Feedback</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Images</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php $counter = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $counter ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['rating']) ?> ★</td>
                        <td><?= htmlspecialchars($row['comment']) ?></td>
                        <td>
                            <?php if (!empty($row['images'])): ?>
                                <?php 
                                $images = explode(',', $row['images']); 
                                foreach ($images as $image): ?>
                                    <img src="<?= htmlspecialchars($image) ?>" alt="Feedback Image" style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">
                                <?php endforeach; ?>
                            <?php else: ?>
                                No Images
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                    <?php $counter++; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No feedback found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>
