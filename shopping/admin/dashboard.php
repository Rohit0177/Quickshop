<?php
session_start();
include_once('includes/config.php');

// ✅ Check admin login correctly
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) {   
    header('location:dashboard.php'); // Redirect to login page
    exit();
} 

// ================= Dashboard Counts =================
$ret = mysqli_query($con, "
    SELECT 
        COUNT(id) AS totalorders,
        COUNT(IF((orderStatus='' OR orderStatus IS NULL), 0, NULL)) AS neworders,
        COUNT(IF(orderStatus='Packed', 0, NULL)) AS packedorders,
        COUNT(IF(orderStatus='Dispatched', 0, NULL)) AS dispatchedorders,
        COUNT(IF(orderStatus='In Transit', 0, NULL)) AS intransitorders,
        COUNT(IF(orderStatus='Out For Delivery', 0, NULL)) AS outfdorders,
        COUNT(IF(orderStatus='Delivered', 0, NULL)) AS deliveredorders,
        COUNT(IF(orderStatus='Cancelled', 0, NULL)) AS cancelledorders
    FROM orders
");
$results = mysqli_fetch_array($ret);

$torders = $results['totalorders'];
$norders = $results['neworders'];
$porders = $results['packedorders'];
$dtorders = $results['dispatchedorders'];
$intorders = $results['intransitorders'];
$otforders = $results['outfdorders'];
$deliveredorders = $results['deliveredorders'];
$cancelledorders = $results['cancelledorders'];

// ✅ Count registered users
$ret1 = mysqli_query($con, "SELECT COUNT(id) AS totalusers FROM users");
$results1 = mysqli_fetch_array($ret1);
$tregusers = $results1['totalusers'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quickshop Portal | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

<?php include_once('includes/header.php'); ?>

<div id="layoutSidenav">
    <?php include_once('includes/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>

                <!-- Row 1 -->
                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Total Orders</div>
                                <div class="text-lg fw-bold"><?php echo $torders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="all-orders.php">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">New Orders</div>
                                <div class="text-lg fw-bold"><?php echo $norders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="new-order.php">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Packed Orders</div>
                                <div class="text-lg fw-bold"><?php echo $porders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="packed-orders.php">View Tasks</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-secondary text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Dispatched Orders</div>
                                <div class="text-lg fw-bold"><?php echo $dtorders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="dispatched-orders.php">View Requests</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">In Transit Orders</div>
                                <div class="text-lg fw-bold"><?php echo $intorders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="intransit-orders.php">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Out for Delivery Orders</div>
                                <div class="text-lg fw-bold"><?php echo $otforders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="outfordelivery-orders.php">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Delivered Orders</div>
                                <div class="text-lg fw-bold"><?php echo $deliveredorders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="delivered-orders.php">View Details</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-dark text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Registered Users</div>
                                <div class="text-lg fw-bold"><?php echo $tregusers; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="registered-users.php">View Requests</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="row">
                    <div class="col-lg-6 col-xl-3 mb-4">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="text-white-75 small">Cancelled Orders</div>
                                <div class="text-lg fw-bold"><?php echo $cancelledorders; ?></div>
                            </div>
                            <div class="card-footer">
                                <a class="text-white stretched-link" href="cancelled-orders.php">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="js/datatables-simple-demo.js"></script>

</body>
</html>
