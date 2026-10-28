<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Track your orders">
    <meta name="author" content="QuickShop">
    <meta name="keywords" content="eCommerce, Orders, Tracking">
    <meta name="robots" content="all">

    <title>Track Orders | QuickShop</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link href="assets/css/lightbox.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/rateit.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/css/config.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Theme Colors -->
    <link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
    <link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
    <link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
    <link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
    <link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
</head>
<body class="cnt-home">

<!-- ============================================== HEADER ============================================== -->
<header class="header-style-1">
    <?php include('includes/top-header.php'); ?>
    <?php include('includes/main-header.php'); ?>
    <?php include('includes/menu-bar.php'); ?>
</header>
<!-- ============================================== HEADER : END ============================================== -->

<!-- ============================================== BREADCRUMB ============================================== -->
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="index.php">Home</a></li>
                <li class="active">Track Your Orders</li>
            </ul>
        </div>
    </div>
</div>
<!-- ============================================== BREADCRUMB : END ============================================== -->

<!-- ============================================== BODY CONTENT ============================================== -->
<div class="body-content outer-top-bd">
    <div class="container">
        <div class="track-order-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12">
                    <h2>Track Your Order</h2>
                    <p class="text-muted" style="margin-bottom: 20px;">
                        Please enter your Order ID and Registered Email below to check your order status.
                        <br> The Order ID was provided on your receipt and confirmation email.
                    </p>

                    <form class="register-form outer-top-xs" role="form" method="post" action="order-details.php">
                        <div class="form-group">
                            <label class="info-title" for="exampleOrderId1">Order ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control unicase-form-control text-input" name="orderid" id="exampleOrderId1" required>
                        </div>

                        <div class="form-group">
                            <label class="info-title" for="exampleBillingEmail1">Registered Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control unicase-form-control text-input" name="email" id="exampleBillingEmail1" required>
                        </div>

                        <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">
                            Track
                        </button>
                    </form>
                </div>
            </div><!-- /.row -->
        </div><!-- /.track-order-page -->

        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        <div class="outer-top-vs">
            <?php include('includes/brands-slider.php'); ?>
        </div>
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->

    </div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ============================================== BODY CONTENT : END ============================================== -->

<!-- ============================================== FOOTER ============================================== -->
<?php include('includes/footer.php'); ?>
<!-- ============================================== FOOTER : END ============================================== -->

<!-- ============================================== SCRIPTS ============================================== -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

<!-- Theme Switcher (optional) -->
<script src="switchstylesheet/switchstylesheet.js"></script>
<script>
$(document).ready(function() { 
    $(".changecolor").switchstylesheet({ seperator: "color" });
    $('.show-theme-options').click(function() {
        $(this).parent().toggleClass('open');
        return false;
    });
});
</script>

</body>
</html>
