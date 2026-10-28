<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Users Log</title>
<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="css/theme.css" rel="stylesheet">
<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
<link type="text/css" href='https://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet'>
<style>
.badge-success { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 4px; }
.badge-danger { background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 4px; }
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
                            <h3>Manage Users</h3>
                        </div>
                        <div class="module-body table">

                            <table cellpadding="0" cellspacing="0" border="0" 
                                   class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Email</th>
                                        <th>User IP</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM userlog ORDER BY id DESC");
                                $cnt = 1;
                                while($row = mysqli_fetch_array($query)) {
                                    // ✅ Safely handle NULL values
                                    $userEmail = $row['userEmail'] ?? '';
                                    $userIP = $row['userip'] ?? '';
                                    $loginTime = $row['loginTime'] ?? '';
                                    $logoutTime = $row['logout'] ?? 'Not Logged Out Yet';
                                    $status = $row['status'] ?? 0;
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($userEmail); ?></td>
                                        <td><?php echo htmlentities($userIP); ?></td>
                                        <td><?php echo htmlentities($loginTime); ?></td>
                                        <td><?php echo htmlentities($logoutTime); ?></td>
                                        <td>
                                            <?php if($status == 1) { ?>
                                                <span class="badge-success">Successful</span>
                                            <?php } else { ?>
                                                <span class="badge-danger">Failed</span>
                                            <?php } ?>
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
