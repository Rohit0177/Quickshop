<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit();
}

// ✅ Add new admin
if (isset($_POST['add_admin'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    $check = mysqli_query($con, "SELECT * FROM adminusers WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $query = mysqli_query($con, "INSERT INTO adminusers (username, password) VALUES ('$username', '$password')");
        if ($query) {
            echo "<script>alert('Admin added successfully!');window.location='manage-admins.php';</script>";
        } else {
            echo "<script>alert('Error adding admin!');</script>";
        }
    }
}

// ✅ Update admin (Edit modal)
if (isset($_POST['update_admin'])) {
    $id = intval($_POST['edit_id']);
    $username = trim($_POST['edit_username']);
    $password = !empty($_POST['edit_password']) ? md5(trim($_POST['edit_password'])) : null;

    if ($password) {
        $query = mysqli_query($con, "UPDATE adminusers SET username='$username', password='$password', updationDate=NOW() WHERE id='$id'");
    } else {
        $query = mysqli_query($con, "UPDATE adminusers SET username='$username', updationDate=NOW() WHERE id='$id'");
    }

    if ($query) {
        echo "<script>alert('Admin updated successfully!');window.location='manage-admins.php';</script>";
    } else {
        echo "<script>alert('Error updating admin!');</script>";
    }
}

// ✅ Delete admin
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    if ($id == 1) {
        echo "<script>alert('Default admin cannot be deleted!');</script>";
    } else {
        $query = mysqli_query($con, "DELETE FROM adminusers WHERE id='$id'");
        if ($query) {
            echo "<script>alert('Admin deleted successfully!');window.location='manage-admins.php';</script>";
        } else {
            echo "<script>alert('Error deleting admin!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Admins | QuickShop</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="images/icons/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

<style>
.table th, .table td { text-align: center; vertical-align: middle; }
.btn-add { background-color: #28a745; color: white; border: none; padding: 6px 12px; border-radius: 4px; }
.btn-add:hover { background-color: #218838; }

.action-icons i {
    font-size: 18px;
    margin: 0 5px;
    cursor: pointer;
    color: #007bff;
}
.icon-remove-sign { color: #dc3545; }
.icon-remove-sign:hover { color: #a71d2a; }
</style>
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
                            <h3>Manage Admin Users</h3>
                            <button class="btn-add" data-toggle="modal" data-target="#addAdminModal">
                                <i class="fa fa-plus"></i> Add Admin
                            </button>
                        </div>
                        <div class="module-body table">

                            <table class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Password (Encrypted)</th>
                                        <th>Creation Date</th>
                                        <th>Updation Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM adminusers ORDER BY id DESC");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo htmlentities($row['username']); ?></td>
                                        <td><?php echo htmlentities($row['password']); ?></td>
                                        <td><?php echo htmlentities($row['creationDate']); ?></td>
                                        <td><?php echo htmlentities($row['updationDate']); ?></td>
                                        <td class="action-icons">
                                            <!-- Change Password -->
                                            <a href="change-password.php?id=<?php echo $row['id']; ?>" title="Change Password">
                                               <i class="icon-edit"></i>
                                            </a>

                                            <!-- Delete -->
                                            <a href="manage-admins.php?del=<?php echo $row['id']; ?>" 
                                               onclick="return confirm('Are you sure you want to delete this admin?');"
                                               title="Delete Admin">
                                                <i class="icon-remove-sign"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php $cnt++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>						
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Add Admin Modal -->
<div id="addAdminModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title">Add New Admin</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="form-group mt-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_admin" class="btn btn-success">Add Admin</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include('include/footer.php'); ?>
<script src="scripts/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
</body>
</html>
