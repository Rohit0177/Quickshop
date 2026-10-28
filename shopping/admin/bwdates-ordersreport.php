<?php 
session_start();
include_once('includes/config.php');

// ✅ Secure session check
if (!isset($_SESSION["aid"]) || strlen($_SESSION["aid"]) == 0) {   
    header('location:index.php'); // redirect to login
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quickshop Portal | Between Dates Order Report</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div id="layoutSidenav">
    <?php include_once('includes/sidebar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Between Dates Order Report</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">B/w Dates Order Report</li>
                </ol>

                <!-- ================= Date Filter Form ================= -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post">                                
                            <div class="row mb-3">
                                <div class="col-md-2">From Date</div>
                                <div class="col-md-4">
                                    <input type="date" name="fromdate" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-2">To Date</div>
                                <div class="col-md-4">
                                    <input type="date" name="todate" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ================= Report Table ================= -->
                <?php 
                if (isset($_POST['submit'])) { 
                    $fdate = mysqli_real_escape_string($con, $_POST['fromdate']);
                    $tdate = mysqli_real_escape_string($con, $_POST['todate']);
                ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="text-center text-primary">
                            Orders Report From <strong><?php echo htmlentities($fdate); ?></strong> 
                            To <strong><?php echo htmlentities($tdate); ?></strong>
                        </h4>
                        <hr>

                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th>Order Amount (₹)</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $query = mysqli_query($con, "
                                SELECT 
                                    orders.id, orderNumber, totalAmount, orderStatus, orderDate, 
                                    users.name 
                                FROM orders 
                                JOIN users ON users.id = orders.userId 
                                WHERE date(orderDate) BETWEEN '$fdate' AND '$tdate'
                                ORDER BY orderDate DESC
                            ");
                            $cnt = 1;
                            $rowcount = mysqli_num_rows($query);

                            if ($rowcount > 0) {
                                while ($row = mysqli_fetch_array($query)) { 
                            ?>  
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td><?php echo htmlentities($row['orderNumber']); ?></td>
                                    <td><?php echo htmlentities($row['name']); ?></td>
                                    <td>₹ <?php echo htmlentities($row['totalAmount']); ?></td>
                                    <td><?php echo htmlentities($row['orderDate']); ?></td>
                                    <td>
                                        <?php 
                                            if ($row['orderStatus'] == '' || $row['orderStatus'] == null) {
                                                echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                            } else {
                                                echo htmlentities($row['orderStatus']);
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="order-details.php?orderid=<?php echo $row['id']; ?>" target="_blank" title="View Order Details">
                                            <i class="fas fa-file-alt fa-lg text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                $cnt++;
                                } 
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-danger'>No orders found for the selected date range.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>

<!-- Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
