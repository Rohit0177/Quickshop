<?php
session_start();
include_once 'include/config.php';

if(strlen($_SESSION['alogin'])==0) { 
    header('location:index.php');
} else {

$oid = intval($_GET['oid']);
$successMsg = "";

if(isset($_POST['submit2'])){
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    // Insert into tracking history
    mysqli_query($con,"INSERT INTO ordertrackhistory(orderId,status,remark) VALUES('$oid','$status','$remark')");
    // Update order status
    mysqli_query($con,"UPDATE orders SET orderStatus='$status' WHERE id='$oid'");
    $successMsg = "Order updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Update Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f4f6f9;
    font-family: 'Poppins', sans-serif;
}
.card {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.table th {
    background-color: #0d6efd;
    color: white;
}
textarea {
    resize: none;
}
.badge-status {
    padding: 5px 10px;
    border-radius: 4px;
}
.badge-inprocess {
    background-color: #ffc107;
    color: #000;
}
.badge-delivered {
    background-color: #28a745;
    color: #fff;
}
.badge-pending {
    background-color: #dc3545;
    color: #fff;
}
</style>
</head>
<body>

<div class="container my-5">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-primary mb-0">🛒 Update Order #<?php echo htmlentities($oid); ?></h3>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">🖨 Print / Download Receipt</button>
        </div>

        <?php if($successMsg){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✔</strong> <?php echo htmlentities($successMsg); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <!-- Order History -->
        <h5 class="mt-3 mb-3 text-secondary">Order Tracking History</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
                if(mysqli_num_rows($ret) > 0){
                    while($row=mysqli_fetch_array($ret)){ ?>
                        <tr>
                            <td><?php echo htmlentities($row['postingDate']); ?></td>
                            <td>
                                <?php 
                                $status = htmlentities($row['status']);
                                if($status == "Delivered") echo "<span class='badge-status badge-delivered'>$status</span>";
                                elseif($status == "in Process") echo "<span class='badge-status badge-inprocess'>$status</span>";
                                else echo "<span class='badge-status badge-pending'>$status</span>";
                                ?>
                            </td>
                            <td><?php echo htmlentities($row['remark']); ?></td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='3' class='text-center text-muted'>No tracking updates yet.</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>

        <hr>

        <?php 
        $delivered = 'Delivered';
        $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
        $num = mysqli_fetch_array($rt);
        $currentStatus = $num['orderStatus'] ?? '';

        if($delivered == $currentStatus){ ?>
            <div class="alert alert-info mt-3 text-center">
                ✅ <strong>Product has been delivered.</strong> No further updates required.
            </div>
        <?php } else { ?>
        <!-- Update Form -->
        <h5 class="mt-4 mb-3 text-secondary">Update Order Status</h5>
        <form method="post">
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Select Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="in Process">In Process</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="remark" class="form-label fw-semibold">Add Remark</label>
                <textarea name="remark" id="remark" class="form-control" rows="4" placeholder="Write your remark..." required></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" name="submit2" class="btn btn-success px-4">✅ Update Order</button>
                <button type="button" class="btn btn-danger px-4" onclick="window.close()">❌ Close Window</button>
            </div>
        </form>
        <?php } ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
