<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
require_once "admin_connect.php";

// Number of records per page
$limit = 2;

// Get the current page number from the URL (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the offset for the query
$offset = ($page - 1) * $limit;

// Get the total number of records
$total_query = "SELECT COUNT(*) AS total FROM user_form";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_records / $limit);

// Fetch records for the current page
$query = "SELECT u.*, b.branch_name 
          FROM user_form u 
          LEFT JOIN branch b ON u.branch_id = b.id 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

?>

<div class="container" style="margin-top:100px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 font-weight-bold text-primary">Manage User / Admin</h6>
                    <a href="./insert_admin.php" class="btn btn-outline-primary btn-sm float-end">Insert User</a>
                </div>
                <div class="card-body">
                    <?= alertmessage(); ?>
                    <?= alertme(); ?>
                    <div class="responsive-table">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Avatar</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Assigned Branch</th>
                                    <th>Role</th>
                                    <th>Date Register</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = $offset + 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($userItem = mysqli_fetch_assoc($result)) {
                                ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><img src="Uploads/<?= $userItem['image'] ?>" width="70px;" height="70px;" alt="Image"></td>
                                            <td><?= $userItem['fname'] ?></td>
                                            <td><?= $userItem['lname'] ?></td>
                                            <td><?= $userItem['email'] ?></td>
                                            <td><?= $userItem['phone'] ?></td>
                                            <td><?= $userItem['branch_name'] ?></td>
                                            <td><?= $userItem['roles_as'] ?></td>
                                            <td><?= $userItem['created'] ?></td>
                                            <td><?= $userItem['is_ban'] == 1 ? '<p class="btn btn-danger btn-sm">Banned</p>' : '<p class="btn btn-success btn-sm">Active</p>' ?></td>
                                            <td><a href="edit_admin.php?id=<?= $userItem['id'] ?>"><i class="fas fa-edit btn btn-outline-primary"></i></a></td>
                                            <td><a href="user-delete.php?id=<?= $userItem['id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')"><i class="fas fa-trash btn btn-outline-warning"></i></a></td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No users found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) { ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php } ?>
                            <?php if ($page < $total_pages) { ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>
