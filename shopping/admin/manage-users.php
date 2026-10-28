<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d-m-Y h:i:s A', time());

// ✅ DELETE USER
if(isset($_GET['del'])) {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM users WHERE id='$id'");
    $_SESSION['delmsg'] = "User deleted successfully!";
    header("location:manage-users.php");
    exit;
}

// ✅ UPDATE USER
if(isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contactno']);
    $shipping = mysqli_real_escape_string($con, $_POST['shipping']);
    $billing = mysqli_real_escape_string($con, $_POST['billing']);

    $query = mysqli_query($con, "UPDATE users SET 
        name='$name',
        email='$email',
        contactno='$contact',
        shippingAddress='$shipping',
        billingAddress='$billing'
        WHERE id='$id'");

    if($query){
        $_SESSION['msg'] = "User details updated successfully!";
    } else {
        $_SESSION['msg'] = "Error: Unable to update user!";
    }
    header("location:manage-users.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Manage Users</title>
<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="css/theme.css" rel="stylesheet">
<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
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



<br />

<table cellpadding="0" cellspacing="0" border="0" 
class="datatable-1 table table-bordered table-striped display" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Contact No</th>
			<th>Shipping Address</th>
			<th>Billing Address</th>
			<th>Reg. Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php 
$query = mysqli_query($con, "SELECT * FROM users ORDER BY id DESC");
$cnt = 1;
while($row = mysqli_fetch_array($query)) { 
?>									
	<tr>
		<td><?php echo htmlentities($cnt);?></td>
		<td><?php echo htmlentities($row['name']);?></td>
		<td><?php echo htmlentities($row['email']);?></td>
		<td><?php echo htmlentities($row['contactno']);?></td>
		<td><?php echo htmlentities($row['shippingAddress'].", ".$row['shippingCity'].", ".$row['shippingState']." - ".$row['shippingPincode']);?></td>
		<td><?php echo htmlentities($row['billingAddress'].", ".$row['billingCity'].", ".$row['billingState']." - ".$row['billingPincode']);?></td>
		<td><?php echo htmlentities($row['regDate']);?></td>
		<td>
			<a href="#edit<?php echo $row['id']; ?>" data-toggle="modal" title="Edit User"><i class="icon-edit"></i></a>
			<a href="manage-users.php?id=<?php echo $row['id']?>&del=delete" 
			   onClick="return confirm('Are you sure you want to delete this user?')" title="Delete User">
			   <i class="icon-remove-sign"></i></a>
		</td>
	</tr>

	<!-- 🔹 Edit User Modal -->
	<div id="edit<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Edit User - <?php echo htmlentities($row['name']); ?></h3>
		</div>
		<div class="modal-body">
			<form method="post">
				<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
				<div class="control-group">
					<label class="control-label">Full Name</label>
					<div class="controls"><input type="text" name="name" value="<?php echo htmlentities($row['name']);?>" class="span8" required></div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls"><input type="email" name="email" value="<?php echo htmlentities($row['email']);?>" class="span8" required></div>
				</div>
				<div class="control-group">
					<label class="control-label">Contact No</label>
					<div class="controls"><input type="text" name="contactno" value="<?php echo htmlentities($row['contactno']);?>" class="span8" required></div>
				</div>
				<div class="control-group">
					<label class="control-label">Shipping Address</label>
					<div class="controls"><textarea name="shipping" class="span8" rows="2"><?php echo htmlentities($row['shippingAddress']);?></textarea></div>
				</div>
				<div class="control-group">
					<label class="control-label">Billing Address</label>
					<div class="controls"><textarea name="billing" class="span8" rows="2"><?php echo htmlentities($row['billingAddress']);?></textarea></div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" name="update" class="btn btn-success">Update</button>
						<button type="button" class="btn" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
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

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
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
