<?php session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
		}else{
			$message="Product ID is invalid";
		}
	}
		echo "<script>alert('Product has been added to the cart')</script>";
		echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="description" content="Modern Shopping Portal">
	<meta name="author" content="">
    <meta name="keywords" content="Shopping, eCommerce, Online Store">
    <meta name="robots" content="all">
    <title>Modern Shopping Portal</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap' rel='stylesheet'>
    
    <style>
    	* {
    		margin: 0;
    		padding: 0;
    		box-sizing: border-box;
    	}
    	
    	body {
    		font-family: 'Poppins', sans-serif;
    		background: #f8f9fa;
    		overflow-x: hidden;
    	}

    	/* Modern Header */
    	.modern-header {
    		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    		padding: 15px 0;
    		box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    		position: sticky;
    		top: 0;
    		z-index: 1000;
    		animation: slideDown 0.5s ease;
    	}

    	@keyframes slideDown {
    		from { transform: translateY(-100%); }
    		to { transform: translateY(0); }
    	}

    	/* Hero Slider */
    	.hero-slider {
    		position: relative;
    		height: 500px;
    		overflow: hidden;
    		margin-bottom: 40px;
    		border-radius: 15px;
    		box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    	}

    	.slider-container {
    		position: relative;
    		width: 100%;
    		height: 100%;
    	}

    	.slide {
    		position: absolute;
    		width: 100%;
    		height: 100%;
    		opacity: 0;
    		transition: opacity 1s ease-in-out;
    		background-size: cover;
    		background-position: center;
    	}

    	.slide.active {
    		opacity: 1;
    		animation: zoomIn 0.8s ease;
    	}

    	@keyframes zoomIn {
    		from { transform: scale(1.1); }
    		to { transform: scale(1); }
    	}

    	.slider-dots {
    		position: absolute;
    		bottom: 20px;
    		left: 50%;
    		transform: translateX(-50%);
    		display: flex;
    		gap: 10px;
    		z-index: 10;
    	}

    	.dot {
    		width: 12px;
    		height: 12px;
    		border-radius: 50%;
    		background: rgba(255,255,255,0.5);
    		cursor: pointer;
    		transition: all 0.3s ease;
    	}

    	.dot.active {
    		background: white;
    		width: 30px;
    		border-radius: 6px;
    	}

    	/* Info Boxes */
    	.info-boxes-modern {
    		display: grid;
    		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    		gap: 20px;
    		margin: 40px 0;
    	}

    	.info-box-modern {
    		background: white;
    		padding: 30px;
    		border-radius: 15px;
    		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    		transition: all 0.3s ease;
    		cursor: pointer;
    		position: relative;
    		overflow: hidden;
    	}

    	.info-box-modern::before {
    		content: '';
    		position: absolute;
    		top: 0;
    		left: -100%;
    		width: 100%;
    		height: 100%;
    		background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    		transition: left 0.5s ease;
    	}

    	.info-box-modern:hover::before {
    		left: 100%;
    	}

    	.info-box-modern:hover {
    		transform: translateY(-10px);
    		box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    	}

    	.info-box-modern .icon {
    		font-size: 40px;
    		margin-bottom: 15px;
    		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    		-webkit-background-clip: text;
    		-webkit-text-fill-color: transparent;
    	}

    	/* Product Grid */
    	.products-grid {
    		display: grid;
    		grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    		gap: 25px;
    		margin: 40px 0;
    	}

    	.product-card {
    		background: white;
    		border-radius: 15px;
    		overflow: hidden;
    		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    		transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    		cursor: pointer;
    		position: relative;
    	}

    	.product-card::after {
    		content: '';
    		position: absolute;
    		top: 0;
    		left: 0;
    		width: 100%;
    		height: 100%;
    		background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    		opacity: 0;
    		transition: opacity 0.3s ease;
    		pointer-events: none;
    	}

    	.product-card:hover::after {
    		opacity: 1;
    	}

    	.product-card:hover {
    		transform: translateY(-15px) scale(1.02);
    		box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    	}

    	.product-image-wrapper {
    		position: relative;
    		height: 300px;
    		overflow: hidden;
    		background: #f8f9fa;
    	}

    	.product-image-wrapper img {
    		width: 100%;
    		height: 100%;
    		object-fit: cover;
    		transition: transform 0.5s ease;
    	}

    	.product-card:hover .product-image-wrapper img {
    		transform: scale(1.15) rotate(2deg);
    	}

    	.discount-badge {
    		position: absolute;
    		top: 15px;
    		right: 15px;
    		background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    		color: white;
    		padding: 8px 15px;
    		border-radius: 25px;
    		font-weight: 600;
    		font-size: 13px;
    		box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
    		animation: pulse 2s infinite;
    	}

    	@keyframes pulse {
    		0%, 100% { transform: scale(1); }
    		50% { transform: scale(1.05); }
    	}

    	.product-info {
    		padding: 20px;
    	}

    	.product-name {
    		font-size: 16px;
    		font-weight: 600;
    		color: #2d3748;
    		margin-bottom: 10px;
    		display: -webkit-box;
    		-webkit-line-clamp: 2;
    		-webkit-box-orient: vertical;
    		overflow: hidden;
    		transition: color 0.3s ease;
    	}

    	.product-card:hover .product-name {
    		color: #667eea;
    	}

    	.product-rating {
    		display: flex;
    		align-items: center;
    		gap: 5px;
    		margin-bottom: 10px;
    	}

    	.stars {
    		color: #fbbf24;
    		font-size: 14px;
    	}

    	.product-price-section {
    		display: flex;
    		align-items: center;
    		gap: 10px;
    		margin-bottom: 15px;
    	}

    	.current-price {
    		font-size: 24px;
    		font-weight: 700;
    		color: #2d3748;
    		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    		-webkit-background-clip: text;
    		-webkit-text-fill-color: transparent;
    	}

    	.original-price {
    		font-size: 16px;
    		color: #a0aec0;
    		text-decoration: line-through;
    	}

    	.add-to-cart-btn {
    		width: 100%;
    		padding: 12px;
    		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    		color: white;
    		border: none;
    		border-radius: 10px;
    		font-weight: 600;
    		font-size: 14px;
    		cursor: pointer;
    		transition: all 0.3s ease;
    		position: relative;
    		overflow: hidden;
    	}

    	.add-to-cart-btn::before {
    		content: '';
    		position: absolute;
    		top: 50%;
    		left: 50%;
    		width: 0;
    		height: 0;
    		border-radius: 50%;
    		background: rgba(255,255,255,0.3);
    		transform: translate(-50%, -50%);
    		transition: width 0.6s ease, height 0.6s ease;
    	}

    	.add-to-cart-btn:hover::before {
    		width: 300px;
    		height: 300px;
    	}

    	.add-to-cart-btn:hover {
    		transform: translateY(-2px);
    		box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    	}

    	.out-of-stock {
    		background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    		color: white;
    		padding: 12px;
    		text-align: center;
    		border-radius: 10px;
    		font-weight: 600;
    	}

    	/* Section Title */
    	.section-title {
    		font-size: 32px;
    		font-weight: 700;
    		color: #2d3748;
    		margin: 50px 0 30px;
    		position: relative;
    		display: inline-block;
    	}

    	.section-title::after {
    		content: '';
    		position: absolute;
    		bottom: -10px;
    		left: 0;
    		width: 60%;
    		height: 4px;
    		background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    		border-radius: 2px;
    		animation: slideRight 1s ease;
    	}

    	@keyframes slideRight {
    		from { width: 0; }
    		to { width: 60%; }
    	}

    	/* Loading Animation */
    	.product-card {
    		animation: fadeInUp 0.6s ease backwards;
    	}

    	.product-card:nth-child(1) { animation-delay: 0.1s; }
    	.product-card:nth-child(2) { animation-delay: 0.2s; }
    	.product-card:nth-child(3) { animation-delay: 0.3s; }
    	.product-card:nth-child(4) { animation-delay: 0.4s; }

    	@keyframes fadeInUp {
    		from {
    			opacity: 0;
    			transform: translateY(30px);
    		}
    		to {
    			opacity: 1;
    			transform: translateY(0);
    		}
    	}

    	/* Responsive */
    	@media (max-width: 768px) {
    		.hero-slider {
    			height: 300px;
    		}

    		.products-grid {
    			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    			gap: 15px;
    		}

    		.product-image-wrapper {
    			height: 200px;
    		}

    		.section-title {
    			font-size: 24px;
    		}
    	}
    </style>
</head>
<body>

<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>

<div class="container" style="margin-top: 20px;">
	<div class="row">
		<div class="col-md-3">
			<?php include('includes/side-menu.php');?>
		</div>

		<div class="col-md-9">
			<!-- Hero Slider -->
			<div class="hero-slider">
				<div class="slider-container">
					<div class="slide active" style="background-image: url(assets/images/sliders/banner_1.webp);"></div>
					<div class="slide" style="background-image: url(assets/images/sliders/banner_2.webp);"></div>
					<div class="slide" style="background-image: url(assets/images/sliders/slider3.jpg);"></div>
				</div>
				<div class="slider-dots">
					<span class="dot active" onclick="currentSlide(0)"></span>
					<span class="dot" onclick="currentSlide(1)"></span>
					<span class="dot" onclick="currentSlide(2)"></span>
				</div>
			</div>

			<!-- Info Boxes -->
			<div class="info-boxes-modern">
				<div class="info-box-modern">
					<i class="icon fa fa-dollar"></i>
					<h4 style="font-weight: 600; margin-bottom: 5px;">Money Back</h4>
					<p style="color: #718096; font-size: 14px; margin: 0;">30 Day Money Back Guarantee</p>
				</div>
				<div class="info-box-modern">
					<i class="icon fa fa-truck"></i>
					<h4 style="font-weight: 600; margin-bottom: 5px;">Free Shipping</h4>
					<p style="color: #718096; font-size: 14px; margin: 0;">Free shipping on orders over Rs. 600</p>
				</div>
				<div class="info-box-modern">
					<i class="icon fa fa-gift"></i>
					<h4 style="font-weight: 600; margin-bottom: 5px;">Special Sale</h4>
					<p style="color: #718096; font-size: 14px; margin: 0;">All items sale up to 20% off</p>
				</div>
			</div>

			<!-- Products Section -->
			<h2 class="section-title">All Products</h2>
			<div class="products-grid">
				<?php
				$ret=mysqli_query($con,"select * from products");
				while ($row=mysqli_fetch_array($ret)) {
					$discount = 0;
					if($row['productPriceBeforeDiscount'] > 0) {
						$discount = round((($row['productPriceBeforeDiscount'] - $row['productPrice']) / $row['productPriceBeforeDiscount']) * 100);
					}
				?>
				<div class="product-card">
					<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>" style="text-decoration: none;">
						<div class="product-image-wrapper">
							<?php if($discount > 0) { ?>
								<div class="discount-badge"><?php echo $discount; ?>% OFF</div>
							<?php } ?>
							<img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="<?php echo htmlentities($row['productName']);?>">
						</div>
						<div class="product-info">
							<div class="product-name"><?php echo htmlentities($row['productName']);?></div>
							<div class="product-rating">
								<span class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-half-o"></i>
								</span>
								<span style="color: #718096; font-size: 13px;">(4.5)</span>
							</div>
							<div class="product-price-section">
								<span class="current-price">₹<?php echo htmlentities($row['productPrice']);?></span>
								<?php if($row['productPriceBeforeDiscount'] > 0) { ?>
									<span class="original-price">₹<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
								<?php } ?>
							</div>
						</div>
					</a>
					<?php if($row['productAvailability']=='In Stock') { ?>
						<div style="padding: 0 20px 20px;">
							<a href="index.php?page=product&action=add&id=<?php echo $row['id']; ?>" style="text-decoration: none;">
								<button class="add-to-cart-btn">
									<i class="fa fa-shopping-cart"></i> Add to Cart
								</button>
							</a>
						</div>
					<?php } else { ?>
						<div style="padding: 0 20px 20px;">
							<div class="out-of-stock">Out of Stock</div>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php include('includes/brands-slider.php');?>
<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script>
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        dots[i].classList.remove('active');
    });
    
    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

function nextSlide() {
    currentSlideIndex = (currentSlideIndex + 1) % slides.length;
    showSlide(currentSlideIndex);
}

function currentSlide(index) {
    currentSlideIndex = index;
    showSlide(currentSlideIndex);
}

// Auto slide every 4 seconds
setInterval(nextSlide, 4000);

// Add cart animation
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        ripple.style.cssText = `
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// Add scroll animation
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.product-card').forEach(card => {
    observer.observe(card);
});
</script>

</body>



<style>
.track-container {
  width: 400px;
  margin: 40px auto;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 30px 20px;
}
.track-step {
  display: flex;
  align-items: flex-start;
  position: relative;
  margin-bottom: 30px;
}
.track-step:last-child {
  margin-bottom: 0;
}
.track-dot {
  width: 18px;
  height: 18px;
  background: #4285f4;
  border-radius: 50%;
  position: relative;
  z-index: 2;
  margin-right: 18px;
  box-shadow: 0 0 0 4px #e3f0fd;
  transition: background 0.3s;
}
.track-step.completed .track-dot {
  background: #34a853;
}
.track-line {
  position: absolute;
  left: 8px;
  top: 18px;
  width: 2px;
  height: 100%;
  background: #e3f0fd;
  z-index: 1;
}
.track-content {
  flex: 1;
}
.track-date {
  font-size: 13px;
  color: #888;
}
.track-status {
  font-weight: bold;
  color: #4285f4;
}
.track-step.completed .track-status {
  color: #34a853;
}
.track-remark {
  font-size: 14px;
  color: #555;
  margin-top: 4px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Animate steps as completed
  var steps = document.querySelectorAll('.track-step');
  steps.forEach(function(step, idx) {
    setTimeout(function() {
      step.classList.add('completed');
    }, idx * 500);
  });
});
</script>



<!-- Track Order Modal -->
 <?php
session_start();
include_once 'includes/config.php';
$oid=intval($_GET['oid']);

// Fetch order details with delivery address
$orderQuery = mysqli_query($con,"SELECT o.*, u.name as customerName, u.contactno, u.shippingAddress, u.shippingCity, u.shippingState, u.shippingPincode 
                                  FROM orders o 
                                  JOIN users u ON o.userId = u.id 
                                  WHERE o.id='$oid'");
$orderData = mysqli_fetch_array($orderQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Your Order - #<?php echo $oid; ?></title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
}

.tracking-container {
    max-width: 1400px;
    margin: 0 auto;
    animation: fadeIn 0.8s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header Card */
.tracking-header {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}

.tracking-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.order-info h1 {
    font-size: 28px;
    color: #2d3748;
    margin-bottom: 10px;
    font-weight: 700;
}

.order-id {
    font-size: 16px;
    color: #667eea;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.btn {
    padding: 12px 25px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.btn-print {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.btn-close {
    background: #f7fafc;
    color: #4a5568;
    border: 2px solid #e2e8f0;
}

/* Main Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

/* Map Container */
.map-container {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    position: relative;
}

.map-header {
    padding: 20px 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.map-header h2 {
    font-size: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.live-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.pulse-dot {
    width: 10px;
    height: 10px;
    background: #48bb78;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
}

#map {
    width: 100%;
    height: 500px;
    position: relative;
}

.delivery-info-overlay {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    z-index: 1000;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
}

.info-text h4 {
    font-size: 13px;
    color: #718096;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-text p {
    font-size: 15px;
    color: #2d3748;
    font-weight: 600;
}

/* Timeline Container */
.timeline-container {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    max-height: 600px;
    overflow-y: auto;
}

.timeline-title {
    font-size: 20px;
    color: #2d3748;
    margin-bottom: 30px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 50px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 16px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    animation: lineGrow 1.5s ease;
}

@keyframes lineGrow {
    from { height: 0; }
    to { height: 100%; }
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    animation: slideIn 0.6s ease backwards;
}

.timeline-item:nth-child(1) { animation-delay: 0.2s; }
.timeline-item:nth-child(2) { animation-delay: 0.4s; }
.timeline-item:nth-child(3) { animation-delay: 0.6s; }

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

.timeline-marker {
    position: absolute;
    left: -42px;
    top: 0;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    border: 4px solid #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    z-index: 2;
}

.timeline-marker i {
    color: #667eea;
    font-size: 16px;
}

.timeline-content {
    background: #f7fafc;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.timeline-content:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.status-badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.status-delivered { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; }
.status-shipped { background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; }
.status-processing { background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); color: white; }
.status-pending { background: linear-gradient(135deg, #ecc94b 0%, #d69e2e 100%); color: white; }

.timeline-date {
    font-size: 13px;
    color: #718096;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.timeline-remark {
    font-size: 14px;
    color: #4a5568;
    line-height: 1.6;
}

/* Vehicle Stats */
.vehicle-stats {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.stat-card {
    text-align: center;
    padding: 20px;
    background: #f7fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 32px;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 13px;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Success Banner */
.success-banner {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 25px 30px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
    animation: bounceIn 0.8s ease;
}

@keyframes bounceIn {
    0% { opacity: 0; transform: scale(0.3); }
    50% { transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}

.success-icon {
    font-size: 40px;
}

.success-text h3 {
    font-size: 20px;
    margin-bottom: 5px;
}

/* No Orders */
.no-orders {
    text-align: center;
    padding: 60px 20px;
}

.no-orders-icon {
    font-size: 60px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

/* Responsive */
@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .delivery-info-overlay {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .vehicle-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    body { padding: 10px; }
    
    .tracking-header { padding: 20px; }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons {
        width: 100%;
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    #map { height: 400px; }
    
    .vehicle-stats {
        grid-template-columns: 1fr;
    }
    
    .timeline-container {
        padding: 20px;
    }
}

@media print {
    body { background: white; padding: 20px; }
    .action-buttons, .map-container { display: none; }
}
</style>
</head>
<body>

<div class="tracking-container">
    <!-- Header -->
    <div class="tracking-header">
        <div class="header-content">
            <div class="order-info">
                <h1>Track Your Order</h1>
                <div class="order-id">
                    <i class="fas fa-hashtag"></i>
                    <span>Order ID: <?php echo $oid; ?></span>
                </div>
            </div>
            <div class="action-buttons">
                <button class="btn btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button class="btn btn-close" onclick="window.close()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Live Map -->
        <div class="map-container">
            <div class="map-header">
                <h2><i class="fas fa-map-marked-alt"></i> Live Tracking</h2>
                <div class="live-indicator">
                    <div class="pulse-dot"></div>
                    <span>Live</span>
                </div>
            </div>
            <div id="map"></div>
            <div class="delivery-info-overlay">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-warehouse"></i></div>
                    <div class="info-text">
                        <h4>From</h4>
                        <p>Warehouse Hub</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-text">
                        <h4>Delivering To</h4>
                        <p><?php echo isset($orderData['shippingCity']) ? htmlentities($orderData['shippingCity']) : 'Your Location'; ?></p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <div class="info-text">
                        <h4>Est. Time</h4>
                        <p id="eta">15-20 mins</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-route"></i></div>
                    <div class="info-text">
                        <h4>Distance</h4>
                        <p id="distance">5.2 km</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="timeline-container">
            <h2 class="timeline-title">
                <i class="fas fa-list-ul"></i>
                Order Timeline
            </h2>

            <?php 
            $ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid' ORDER BY id DESC");
            $num = mysqli_num_rows($ret);
            
            if($num > 0) {
            ?>
                <div class="timeline">
                    <?php
                    while($row = mysqli_fetch_array($ret)) {
                        $status = strtolower($row['status']);
                        $statusClass = 'status-pending';
                        $icon = 'fa-clock';
                        
                        if(strpos($status, 'delivered') !== false) {
                            $statusClass = 'status-delivered';
                            $icon = 'fa-check-circle';
                        } elseif(strpos($status, 'shipped') !== false || strpos($status, 'dispatch') !== false) {
                            $statusClass = 'status-shipped';
                            $icon = 'fa-truck';
                        } elseif(strpos($status, 'process') !== false) {
                            $statusClass = 'status-processing';
                            $icon = 'fa-spinner';
                        }
                    ?>
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="fas <?php echo $icon; ?>"></i>
                            </div>
                            <div class="timeline-content">
                                <span class="status-badge <?php echo $statusClass; ?>">
                                    <?php echo htmlentities($row['status']); ?>
                                </span>
                                <div class="timeline-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo date('M d, Y - h:i A', strtotime($row['postingDate'])); ?>
                                </div>
                                <div class="timeline-remark">
                                    <?php echo htmlentities($row['remark']); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="no-orders">
                    <div class="no-orders-icon"><i class="fas fa-box-open"></i></div>
                    <h3>Order Not Processed Yet</h3>
                    <p>We'll update you soon!</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Vehicle Stats -->
    <div class="vehicle-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shipping-fast"></i></div>
            <div class="stat-value" id="speed">45</div>
            <div class="stat-label">Speed (km/h)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-road"></i></div>
            <div class="stat-value" id="covered">3.8</div>
            <div class="stat-label">Distance Covered</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-map-signs"></i></div>
            <div class="stat-value" id="remaining">1.4</div>
            <div class="stat-label">Remaining (km)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
            <div class="stat-value">Raj K.</div>
            <div class="stat-label">Delivery Partner</div>
        </div>
    </div>

    <?php
    $st = 'Delivered';
    $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
    if($row_order = mysqli_fetch_array($rt)) {
        $currentSt = $row_order['orderStatus'];
        if($st == $currentSt) {
    ?>
        <div class="success-banner" style="margin-top: 20px;">
            <div class="success-icon"><i class="fas fa-check-circle"></i></div>
            <div class="success-text">
                <h3>Successfully Delivered!</h3>
                <p>Your order has been delivered. Thank you for shopping with us!</p>
            </div>
        </div>
    <?php }} ?>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Initialize map
const map = L.map('map').setView([23.0225, 72.5714], 13); // Ahmedabad coordinates

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Warehouse location (starting point)
const warehouse = [23.0225, 72.5714];
const destination = [23.0395, 72.5660]; // Delivery destination

// Custom icons
const warehouseIcon = L.divIcon({
    html: '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);"><i class="fas fa-warehouse"></i></div>',
    className: 'custom-icon',
    iconSize: [40, 40]
});

const deliveryIcon = L.divIcon({
    html: '<div style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);"><i class="fas fa-home"></i></div>',
    className: 'custom-icon',
    iconSize: [40, 40]
});

const vehicleIcon = L.divIcon({
    html: '<div style="background: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.3); border: 3px solid #667eea; animation: bounce 1s infinite;"><i class="fas fa-motorcycle" style="color: #667eea;"></i></div>',
    className: 'vehicle-icon',
    iconSize: [50, 50]
});

// Add CSS for bounce animation
const style = document.createElement('style');
style.textContent = `
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
`;
document.head.appendChild(style);

// Add markers
L.marker(warehouse, {icon: warehouseIcon}).addTo(map)
    .bindPopup('<b>Warehouse</b><br>Your order started from here');

L.marker(destination, {icon: deliveryIcon}).addTo(map)
    .bindPopup('<b>Delivery Location</b><br>Your package will arrive here');

// Draw route
const routeCoordinates = [
    warehouse,
    [23.0270, 72.5700],
    [23.0310, 72.5680],
    [23.0350, 72.5670],
    destination
];

const route = L.polyline(routeCoordinates, {
    color: '#667eea',
    weight: 5,
    opacity: 0.7,
    dashArray: '10, 10',
    dashOffset: 0
}).addTo(map);

// Animate route drawing
let offset = 0;
setInterval(() => {
    offset -= 1;
    route.setStyle({dashOffset: offset});
}, 50);

// Animate vehicle movement
let currentIndex = 0;
let vehicle = L.marker(warehouse, {icon: vehicleIcon}).addTo(map);

function animateVehicle() {
    if (currentIndex < routeCoordinates.length - 1) {
        const start = routeCoordinates[currentIndex];
        const end = routeCoordinates[currentIndex + 1];
        const steps = 50;
        let step = 0;

        const interval = setInterval(() => {
            if (step <= steps) {
                const lat = start[0] + (end[0] - start[0]) * (step / steps);
                const lng = start[1] + (end[1] - start[1]) * (step / steps);
                vehicle.setLatLng([lat, lng]);
                
                // Update stats
                const progress = ((currentIndex + step/steps) / (routeCoordinates.length - 1)) * 100;
                document.getElementById('covered').textContent = (5.2 * progress / 100).toFixed(1);
                document.getElementById('remaining').textContent = (5.2 * (100 - progress) / 100).toFixed(1);
                document.getElementById('eta').textContent = Math.max(1, Math.ceil(20 * (100 - progress) / 100)) + ' mins';
                
                step++;
            } else {
                clearInterval(interval);
                currentIndex++;
                if (currentIndex < routeCoordinates.length - 1) {
                    setTimeout(animateVehicle, 100);
                }
            }
        }, 100);
    }
}

// Start animation after 1 second
setTimeout(animateVehicle, 1000);

// Fit map to show entire route
map.fitBounds(route.getBounds(), {padding: [50, 50]});

// Simulate speed changes
setInterval(() => {
    const speeds = [35, 40, 45, 50, 42, 38];
    document.getElementById('speed').textContent = speeds[Math.floor(Math.random() * speeds.length)];
}, 3000);
</script>

</body>
</html>


<!-- demo of accoint -->
 <?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    if(isset($_POST['update'])) {
        $name=$_POST['name'];
        $contactno=$_POST['contactno'];
        $query=mysqli_query($con,"update users set name='$name',contactno='$contactno' where id='".$_SESSION['id']."'");
        if($query) {
            echo "<script>alert('Your info has been updated');</script>";
        }
    }

    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    if(isset($_POST['submit'])) {
        $sql=mysqli_query($con,"SELECT password FROM users where password='".md5($_POST['cpass'])."' && id='".$_SESSION['id']."'");
        $num=mysqli_fetch_array($sql);
        if($num>0) {
            $con=mysqli_query($con,"update users set password='".md5($_POST['newpass'])."', updationDate='$currentTime' where id='".$_SESSION['id']."'");
            echo "<script>alert('Password Changed Successfully !!');</script>";
        } else {
            echo "<script>alert('Current Password not match !!');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="Account, Profile, eCommerce">
    <meta name="robots" content="all">

    <title>My Account - Modern Profile</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Modern CSS -->
    <link rel="stylesheet" href="assets/css/account-profile-modern.css">
    
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <script type="text/javascript">
    function valid() {
        if(document.chngpwd.cpass.value=="") {
            alert("Current Password Field is Empty !!");
            document.chngpwd.cpass.focus();
            return false;
        }
        else if(document.chngpwd.newpass.value=="") {
            alert("New Password Field is Empty !!");
            document.chngpwd.newpass.focus();
            return false;
        }
        else if(document.chngpwd.cnfpass.value=="") {
            alert("Confirm Password Field is Empty !!");
            document.chngpwd.cnfpass.focus();
            return false;
        }
        else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value) {
            alert("Password and Confirm Password Field do not match !!");
            document.chngpwd.cnfpass.focus();
            return false;
        }
        return true;
    }

    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        if(!strengthBar) return;
        
        strengthBar.classList.remove('weak', 'medium', 'strong');
        strengthBar.classList.add('show');
        
        let strength = 0;
        if(password.length >= 8) strength++;
        if(/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if(/[0-9]/.test(password)) strength++;
        if(/[^a-zA-Z0-9]/.test(password)) strength++;

        if(strength <= 2) {
            strengthBar.classList.add('weak');
        } else if(strength === 3) {
            strengthBar.classList.add('medium');
        } else {
            strengthBar.classList.add('strong');
        }
    }
    </script>
	<style>
		/* Modern Account Profile CSS - Amazon Style */

/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', 'Amazon Ember', Arial, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

/* Container */
.body-content {
    padding: 40px 0;
}

.checkout-box {
    max-width: 1200px;
    margin: 0 auto;
}

/* Breadcrumb */
.breadcrumb {
    background: white;
    padding: 20px 0;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.breadcrumb-inner ul {
    margin: 0;
    padding: 0;
}

.breadcrumb-inner li {
    display: inline-block;
    color: #666;
    font-size: 14px;
}

.breadcrumb-inner li:not(:last-child)::after {
    content: '›';
    margin: 0 10px;
    color: #999;
}

.breadcrumb-inner li a {
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-inner li a:hover {
    color: #0056b3;
}

/* Main Panel Container */
.checkout-steps {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: none;
}

/* Panel Default */
.panel-default {
    border: none;
    margin-bottom: 0;
    border-radius: 0;
}

.panel-default + .panel-default {
    border-top: 2px solid #f5f5f5;
}

/* Panel Heading */
.panel-heading {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0;
    transition: all 0.3s ease;
}

.panel-heading:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateX(5px);
}

.unicase-checkout-title {
    margin: 0;
    padding: 0;
}

.unicase-checkout-title a {
    display: flex;
    align-items: center;
    padding: 25px 30px;
    color: white;
    text-decoration: none;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.unicase-checkout-title a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    transition: left 0.5s ease;
}

.unicase-checkout-title a:hover::before {
    left: 100%;
}

.unicase-checkout-title span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: white;
    color: #667eea;
    border-radius: 50%;
    margin-right: 15px;
    font-weight: 700;
    font-size: 18px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.unicase-checkout-title a:hover span {
    transform: rotate(360deg) scale(1.1);
}

/* Panel Collapse */
.panel-collapse {
    border: none;
}

.panel-collapse.in,
.panel-collapse.collapsing {
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 1000px;
    }
}

/* Panel Body */
.panel-body {
    padding: 40px;
    background: #fafbfc;
}

.panel-body h4 {
    color: #2d3748;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 3px solid #667eea;
    display: inline-block;
}

/* Form Styles */
.register-form {
    max-width: 600px;
}

.form-group {
    margin-bottom: 25px;
    animation: fadeInUp 0.6s ease backwards;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.info-title {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-title span {
    color: #e53e3e;
    margin-left: 3px;
}

/* Form Controls */
.form-control,
.unicase-form-control {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: white;
    font-family: 'Poppins', sans-serif;
}

.form-control:focus,
.unicase-form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.form-control:read-only,
.unicase-form-control:read-only {
    background: #f7fafc;
    cursor: not-allowed;
    color: #718096;
}

.form-control:hover:not(:read-only),
.unicase-form-control:hover:not(:read-only) {
    border-color: #cbd5e0;
}

/* Buttons */
.btn-primary,
.checkout-page-button {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 15px 40px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.btn-primary::before,
.checkout-page-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.btn-primary:hover::before,
.checkout-page-button:hover::before {
    width: 300px;
    height: 300px;
}

.btn-primary:hover,
.checkout-page-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.btn-primary:active,
.checkout-page-button:active {
    transform: translateY(-1px);
}

/* Sidebar */
.col-md-4 {
    animation: slideInRight 0.8s ease;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .body-content {
        padding: 20px 0;
    }

    .panel-body {
        padding: 25px 20px;
    }

    .unicase-checkout-title a {
        padding: 20px;
        font-size: 16px;
    }

    .unicase-checkout-title span {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }

    .form-control,
    .unicase-form-control {
        padding: 12px 15px;
        font-size: 14px;
    }

    .btn-primary,
    .checkout-page-button {
        padding: 12px 30px;
        font-size: 14px;
        width: 100%;
    }
}

/* Loading Animation */
.form-control.loading,
.unicase-form-control.loading {
    background: linear-gradient(
        90deg,
        #f7fafc 0%,
        #edf2f7 50%,
        #f7fafc 100%
    );
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Success Message */
.alert-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: none;
    box-shadow: 0 5px 15px rgba(72, 187, 120, 0.3);
    animation: bounceIn 0.6s ease;
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Error Message */
.alert-danger {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: none;
    box-shadow: 0 5px 15px rgba(245, 101, 101, 0.3);
}

/* Input Icons */
.form-group.with-icon {
    position: relative;
}

.form-group.with-icon::before {
    content: '\f007';
    font-family: 'FontAwesome';
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 16px;
}

.form-group.with-icon.email::before {
    content: '\f0e0';
}

.form-group.with-icon.phone::before {
    content: '\f095';
}

.form-group.with-icon.password::before {
    content: '\f023';
}

.form-group.with-icon .form-control {
    padding-left: 50px;
}

/* Floating Labels */
.floating-label {
    position: relative;
}

.floating-label input:focus + label,
.floating-label input:not(:placeholder-shown) + label {
    top: -10px;
    left: 15px;
    font-size: 12px;
    color: #667eea;
    background: white;
    padding: 0 5px;
}

.floating-label label {
    position: absolute;
    top: 17px;
    left: 20px;
    transition: all 0.3s ease;
    pointer-events: none;
    color: #a0aec0;
}

/* Password Strength Indicator */
.password-strength {
    height: 4px;
    border-radius: 2px;
    margin-top: 10px;
    transition: all 0.3s ease;
    display: none;
}

.password-strength.show {
    display: block;
}

.password-strength.weak {
    background: #f56565;
    width: 33%;
}

.password-strength.medium {
    background: #ed8936;
    width: 66%;
}

.password-strength.strong {
    background: #48bb78;
    width: 100%;
}

/* Checkbox Styles */
.custom-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.custom-checkbox input {
    display: none;
}

.custom-checkbox .checkmark {
    width: 22px;
    height: 22px;
    border: 2px solid #e2e8f0;
    border-radius: 5px;
    margin-right: 10px;
    position: relative;
    transition: all 0.3s ease;
}

.custom-checkbox input:checked + .checkmark {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.custom-checkbox input:checked + .checkmark::after {
    content: '\2714';
    position: absolute;
    color: white;
    font-size: 14px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Tooltip */
.tooltip-icon {
    display: inline-block;
    width: 18px;
    height: 18px;
    background: #cbd5e0;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 18px;
    font-size: 12px;
    margin-left: 5px;
    cursor: help;
    position: relative;
}

.tooltip-icon:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #2d3748;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    margin-bottom: 5px;
    z-index: 1000;
}

/* Print Styles */
@media print {
    body {
        background: white;
    }

    .breadcrumb,
    .btn-primary,
    .checkout-page-button {
        display: none;
    }

    .checkout-steps {
        box-shadow: none;
    }
}
	</style>
</head>
<body class="cnt-home">

<header class="header-style-1">
    <?php include('includes/top-header.php');?>
    <?php include('includes/main-header.php');?>
    <?php include('includes/menu-bar.php');?>
</header>

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li class='active'>My Account</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content outer-top-bd">
    <div class="container">
        <div class="checkout-box inner-bottom-sm">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        
                        <!-- Profile Information Panel -->
                        <div class="panel panel-default checkout-step-01">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                        <span>1</span>
                                        <i class="fas fa-user-circle"></i> My Profile Information
                                    </a>
                                </h4>
                            </div>
                            
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <h4><i class="fas fa-id-card"></i> Personal Information</h4>
                                        <div class="col-md-12 col-sm-12 already-registered-login">
                                            <?php
                                            $query=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
                                            while($row=mysqli_fetch_array($query)) {
                                            ?>
                                            <form class="register-form" role="form" method="post">
                                                <div class="form-group with-icon">
                                                    <label class="info-title" for="name">
                                                        <i class="fas fa-user"></i> Full Name <span>*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control unicase-form-control text-input" 
                                                           value="<?php echo htmlentities($row['name']); ?>" 
                                                           id="name" 
                                                           name="name" 
                                                           placeholder="Enter your full name"
                                                           required="required">
                                                </div>

                                                <div class="form-group with-icon email">
                                                    <label class="info-title" for="exampleInputEmail1">
                                                        <i class="fas fa-envelope"></i> Email Address <span>*</span>
                                                    </label>
                                                    <input type="email" 
                                                           class="form-control unicase-form-control text-input" 
                                                           id="exampleInputEmail1" 
                                                           value="<?php echo htmlentities($row['email']); ?>" 
                                                           readonly>
                                                    <small style="color: #718096; display: block; margin-top: 5px;">
                                                        <i class="fas fa-info-circle"></i> Email cannot be changed for security reasons
                                                    </small>
                                                </div>

                                                <div class="form-group with-icon phone">
                                                    <label class="info-title" for="contactno">
                                                        <i class="fas fa-phone"></i> Contact Number <span>*</span>
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control unicase-form-control text-input" 
                                                           id="contactno" 
                                                           name="contactno" 
                                                           required="required" 
                                                           value="<?php echo htmlentities($row['contactno']); ?>" 
                                                           maxlength="10"
                                                           placeholder="Enter 10 digit mobile number">
                                                </div>

                                                <button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">
                                                    <i class="fas fa-save"></i> Update Profile
                                                </button>
                                            </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Panel -->
                        <div class="panel panel-default checkout-step-02">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
                                        <span>2</span>
                                        <i class="fas fa-key"></i> Change Password
                                    </a>
                                </h4>
                            </div>
                            
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <h4><i class="fas fa-shield-alt"></i> Security Settings</h4>
                                    
                                    <form class="register-form" role="form" method="post" name="chngpwd" onSubmit="return valid();">
                                        <div class="form-group with-icon password">
                                            <label class="info-title" for="cpass">
                                                <i class="fas fa-lock"></i> Current Password <span>*</span>
                                            </label>
                                            <input type="password" 
                                                   class="form-control unicase-form-control text-input" 
                                                   id="cpass" 
                                                   name="cpass" 
                                                   placeholder="Enter your current password"
                                                   required="required">
                                        </div>

                                        <div class="form-group with-icon password">
                                            <label class="info-title" for="newpass">
                                                <i class="fas fa-lock"></i> New Password <span>*</span>
                                            </label>
                                            <input type="password" 
                                                   class="form-control unicase-form-control text-input" 
                                                   id="newpass" 
                                                   name="newpass"
                                                   placeholder="Enter new password (min 8 characters)"
                                                   onkeyup="checkPasswordStrength(this.value)">
                                            <div id="passwordStrength" class="password-strength"></div>
                                            <small style="color: #718096; display: block; margin-top: 10px;">
                                                <i class="fas fa-info-circle"></i> Use 8+ characters with mix of letters, numbers & symbols
                                            </small>
                                        </div>

                                        <div class="form-group with-icon password">
                                            <label class="info-title" for="cnfpass">
                                                <i class="fas fa-lock"></i> Confirm Password <span>*</span>
                                            </label>
                                            <input type="password" 
                                                   class="form-control unicase-form-control text-input" 
                                                   id="cnfpass" 
                                                   name="cnfpass" 
                                                   placeholder="Re-enter new password"
                                                   required="required">
                                        </div>

                                        <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">
                                            <i class="fas fa-check-circle"></i> Change Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php include('includes/myaccount-sidebar.php');?>
            </div>
        </div>

        <?php include('includes/brands-slider.php');?>
    </div>
</div>

<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

<script>
// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if(href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if(target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Form validation feedback
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('blur', function() {
        if(this.value && !this.readOnly) {
            this.style.borderColor = '#48bb78';
        }
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Phone number validation
const phoneInput = document.getElementById('contactno');
if(phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if(this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
}

// Add loading state to buttons
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        if(btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
        }
    });
});

// Confirm password match indicator
const newPass = document.getElementById('newpass');
const cnfPass = document.getElementById('cnfpass');

if(cnfPass) {
    cnfPass.addEventListener('keyup', function() {
        if(newPass.value === this.value && this.value !== '') {
            this.style.borderColor = '#48bb78';
        } else if(this.value !== '') {
            this.style.borderColor = '#f56565';
        } else {
            this.style.borderColor = '#e2e8f0';
        }
    });
}
</script>

</body>
</html>
<?php } ?>