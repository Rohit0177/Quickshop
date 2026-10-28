<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
    exit();
}

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d-m-Y h:i:s A', time());

// ✅ Get Admin ID from URL
$admin_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (isset($_POST['submit'])) {
    $current = md5($_POST['password']);
    $newpass = md5($_POST['newpassword']);
    $confirm = md5($_POST['confirmpassword']);

    if ($newpass != $confirm) {
        $_SESSION['msg'] = "❌ New Password and Confirm Password do not match!";
    } else {
        // ✅ Verify old password
        $sql = mysqli_query($con, "SELECT password FROM adminusers WHERE id='$admin_id' AND password='$current'");
        if (mysqli_num_rows($sql) > 0) {
            $update = mysqli_query($con, "UPDATE adminusers SET password='$newpass', updationDate='$currentTime' WHERE id='$admin_id'");
            if ($update) {
                $_SESSION['msg'] = "✅ Password Changed Successfully!";
            }
        } else {
            $_SESSION['msg'] = "❌ Old Password does not match!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Admin Password</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="images/icons/css/font-awesome.css">
<script>
function valid() {
    if(document.chngpwd.password.value=="") { alert("Enter Current Password!"); return false; }
    if(document.chngpwd.newpassword.value=="") { alert("Enter New Password!"); return false; }
    if(document.chngpwd.confirmpassword.value=="") { alert("Enter Confirm Password!"); return false; }
    if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value) {
        alert("Password and Confirm Password do not match!");
        return false;
    }
    return true;
}
</script>
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
                        <div class="module-head"><h3>Change Admin Password</h3></div>
                        <div class="module-body">

                        <?php if(isset($_SESSION['msg'])) { ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php echo htmlentities($_SESSION['msg']); $_SESSION['msg']=""; ?>
                            </div>
                        <?php } ?>

                        <form class="form-horizontal row-fluid" name="chngpwd" method="post" onSubmit="return valid();">
                            <div class="control-group">
                                <label class="control-label">Current Password</label>
                                <div class="controls">
                                    <input type="password" name="password" placeholder="Enter Current Password" class="span8 tip" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">New Password</label>
                                <div class="controls">
                                    <input type="password" name="newpassword" placeholder="Enter New Password" class="span8 tip" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Confirm New Password</label>
                                <div class="controls">
                                    <input type="password" name="confirmpassword" placeholder="Re-enter New Password" class="span8 tip" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>
<script src="scripts/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
