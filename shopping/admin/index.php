<?php
session_start();
error_reporting(0);
include("include/config.php");

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));

    // ✅ Check in adminusers table (not admin)
    $ret = mysqli_query($con, "SELECT * FROM adminusers WHERE username='$username' AND password='$password'");
    $num = mysqli_fetch_array($ret);

    if ($num) {
        $_SESSION['alogin'] = $num['username'];
        $_SESSION['id'] = $num['id'];
        header("location:manage-admins.php");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid username or password!";
        header("location:index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QuickShop Portal | Admin Login</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="../index.php">QuickShop Portal | Admin</a>
				<ul class="nav pull-right">
					<li><a href="../index.php">Back to Portal</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical" method="post">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<span style="color:red;">
							<?php echo htmlentities($_SESSION['errmsg']); ?>
							<?php echo htmlentities($_SESSION['errmsg'] = ""); ?>
						</span>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" name="username" placeholder="Username" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="password" name="password" placeholder="Password" required>
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" class="btn btn-primary pull-right" name="submit">Login</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="footer">
		<div class="container">
			<b class="copyright">QuickShop</b>
		</div>
	</div>

	<script src="scripts/jquery-1.9.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
