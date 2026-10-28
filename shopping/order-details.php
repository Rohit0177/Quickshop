<?php 
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="Order History Page">
    <meta name="author" content="">
    <meta name="keywords" content="QuickShop, Orders, History">
    <meta name="robots" content="all">

    <title>Order History</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <script type="text/javascript">
    var popUpWin = 0;
    function popUpWindow(URLStr, left, top, width, height) {
        if (popUpWin) {
            if (!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr, 'popUpWin', 
            'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' 
            + width + ',height=' + height + ',left=' + left + ',top=' + top);
    }
    </script>
</head>

<body class="cnt-home">

<!-- ================================= HEADER ================================= -->
<header class="header-style-1">
    <?php include('includes/top-header.php');?>
    <?php include('includes/main-header.php');?>
    <?php include('includes/menu-bar.php');?>
</header>
<!-- ================================= HEADER END ================================= -->

<!-- ================================= BREADCRUMB ================================= -->
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="index.php">Home</a></li>
                <li class="active">Order History</li>
            </ul>
        </div>
    </div>
</div>
<!-- ================================= BREADCRUMB END ================================= -->

<!-- ================================= BODY ================================= -->
<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row inner-bottom-sm">
            <div class="shopping-cart">
                <div class="col-md-12 col-sm-12 shopping-cart-table">
                    <div class="table-responsive">
                        <form name="cart" method="post">	
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price / Unit</th>
                                        <th>Grand Total</th>
                                        <th>Payment Method</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$orderid = $_POST['orderid'];
$email   = $_POST['email'];

if (!empty($orderid) && !empty($email)) {
    // Verify order + email match
    $ret = mysqli_query($con, "
        SELECT usr.email, odrs.id 
        FROM users AS usr 
        JOIN orders AS odrs ON usr.id = odrs.userId 
        WHERE usr.email = '$email' AND odrs.id = '$orderid'
    ");
    $num = mysqli_num_rows($ret);

    if ($num > 0) {
        $query = mysqli_query($con, "
            SELECT 
                p.productImage1 AS pimg1,
                p.productName AS pname,
                o.productId AS opid,
                o.quantity AS qty,
                p.productPrice AS pprice,
                o.paymentMethod AS paym,
                o.orderDate AS odate,
                o.id AS orderid
            FROM orders o
            JOIN products p ON o.productId = p.id
            WHERE o.id = '$orderid' AND o.paymentMethod IS NOT NULL
        ");
        $cnt = 1;
        while ($row = mysqli_fetch_array($query)) {
?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td class="cart-image">
                                            <img src="admin/productimages/<?php echo htmlentities($row['opid']); ?>/<?php echo htmlentities($row['pimg1']); ?>" 
                                                 alt="<?php echo htmlentities($row['pname']); ?>" width="90" height="90">
                                        </td>
                                        <td>
                                            <h4 class="cart-product-description">
                                                <a href="product-details.php?pid=<?php echo $row['opid']; ?>">
                                                    <?php echo htmlentities($row['pname']); ?>
                                                </a>
                                            </h4>
                                        </td>
                                        <td><?php echo $qty = $row['qty']; ?></td>
                                        <td>Rs. <?php echo $price = $row['pprice']; ?></td>
                                        <td>Rs. <?php echo $qty * $price; ?></td>
                                        <td><?php echo htmlentities($row['paym']); ?></td>
                                        <td><?php echo htmlentities($row['odate']); ?></td>
                                        <td>
                                            <a href="javascript:void(0);" 
                                               onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']);?>',600,200,600,600);" 
                                               title="Track Order" 
                                               class="btn btn-info btn-sm">
                                               Track
                                            </a>
                                        </td>
                                    </tr>
<?php 
        $cnt++;
        } 
    } else { 
?>
                                    <tr><td colspan="9" class="text-center text-danger">Either Order ID or Registered Email ID is invalid.</td></tr>
<?php 
    }
} else { 
?>
                                    <tr><td colspan="9" class="text-center text-warning">Please enter both Order ID and Email from the Track Order page.</td></tr>
<?php 
}
?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div><!-- /.shopping-cart -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.body-content -->

<!-- ================================= BRANDS CAROUSEL ================================= -->
<div class="outer-top-vs">
    <?php include('includes/brands-slider.php'); ?>
</div>
<!-- ================================= FOOTER ================================= -->
<?php include('includes/footer.php'); ?>
<!-- ================================= FOOTER END ================================= -->

<!-- JS -->
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
</body>
</html>
