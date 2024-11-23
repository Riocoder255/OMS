<?php
include_once './layouts/header.php';
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
require_once './admin_connect.php';

$paramResult = checkParamId('id');
if (!is_numeric($paramResult)) {
    echo '<h5>' . $paramResult . '</h5>';
    return false;
}
$cat = getById('sub_category', $paramResult);
?>

<div class="container-sm" style="padding-left:14%; margin-top:9%;">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
    </div>
    <div class="card-body">
        <?php
        if ($cat['status'] == 200) {
        ?>
            <form action="./category-form.php" method="POST" enctype="multipart/form-data">
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <input type="hidden" name="cat_id" class="form-control" value="<?= $cat['data']['id']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <label for="">Category Title</label>
                    <input type="text" name="cat_name" class="form-control" value="<?= $cat['data']['cat_name']; ?>">
                </div>
                <button type="submit" name="update_cat" class="btn btn-primary">Update</button>
            </form>
        <?php
        } else {
            echo '<h5>' . $cat['message'] . '</h5>';
        }
        ?>
    </div>
</div>

<?php
include_once './layouts/scripts.php';
include_once './layouts/footer.php';
?>
