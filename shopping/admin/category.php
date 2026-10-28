<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
date_default_timezone_set('Asia/Kolkata'); // Set your timezone
$currentTime = date('d-m-Y h:i:s A', time());

// ✅ Add Category
if(isset($_POST['submit'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $sql = mysqli_query($con, "INSERT INTO category(categoryName, categoryDescription) VALUES('$category', '$description')");
    
    if($sql) {
        $_SESSION['msg'] = "✅ Category created successfully!";
    } else {
        $_SESSION['msg'] = "❌ Error creating category!";
    }
}

// ✅ Delete Category
if(isset($_GET['del'])) {
    mysqli_query($con, "DELETE FROM category WHERE id = '".$_GET['id']."'");
    $_SESSION['delmsg'] = "Category deleted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Category</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet'>
</head>
<body>
<?php include('include/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?>				
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Category</h3>
                        </div>
                        <div class="module-body">

                            <!-- ✅ Success / Error Messages -->
                            <?php if(!empty($_SESSION['msg'])) { ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong><?php echo htmlentities($_SESSION['msg']); ?></strong>
                                </div>
                                <?php $_SESSION['msg'] = ""; } ?>

                            <?php if(!empty($_SESSION['delmsg'])) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong><?php echo htmlentities($_SESSION['delmsg']); ?></strong>
                                </div>
                                <?php $_SESSION['delmsg'] = ""; } ?>

                            <br />

                            <!-- ✅ Add Category Form -->
                            <form class="form-horizontal row-fluid" name="Category" method="post">
                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Category Name</label>
                                    <div class="controls">
                                        <input type="text" placeholder="Enter Category Name" name="category" class="span8 tip" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Description</label>
                                    <div class="controls">
                                        <textarea class="span8" name="description" rows="5" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" name="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ✅ Manage Categories Table -->
                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Categories</h3>
                        </div>
                        <div class="module-body table">
                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Creation Date</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM category");
                                $cnt = 1;
                                while($row = mysqli_fetch_array($query)) { 
                                    // ✅ Prevent NULL warnings
                                    $categoryName = $row['categoryName'] ?? '';
                                    $description = $row['categoryDescription'] ?? '';
                                    $creationDate = $row['creationDate'] ?? '';
                                    $updationDate = $row['updationDate'] ?? 'Not Updated';
                                ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($categoryName); ?></td>
                                        <td><?php echo htmlentities($description); ?></td>
                                        <td><?php echo htmlentities($creationDate); ?></td>
                                        <td><?php echo htmlentities($updationDate); ?></td>
                                        <td>
                                            <a href="edit-category.php?id=<?php echo $row['id']; ?>"><i class="icon-edit"></i></a>
                                            <a href="category.php?id=<?php echo $row['id']; ?>&del=delete" onClick="return confirm('Are you sure you want to delete this category?')"><i class="icon-remove-sign"></i></a>
                                        </td>
                                    </tr>
                                <?php $cnt++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>						
                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php'); ?>

<script src="scripts/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    });
</script>
</body>
</html>
<?php } ?>
