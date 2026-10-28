<?php
$brands = [
    [
        'id' => 1,
        'name' => 'Fitelo',
        'image' => 'https://images.unsplash.com/photo-1511690656952-34342bb7c2f2?w=600&h=400&fit=crop',
        'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTn9eIyAlF3ED-d4Sr9NcI5QHuYahJ7YtD9rQ&s',
        'logo_hover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTn9eIyAlF3ED-d4Sr9NcI5QHuYahJ7YtD9rQ&s', // Example hover logo
        'description' => 'Health & Nutrition Brand'
    ],
    [
        'id' => 2,
        'name' => 'Nutraj',
        'image' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=600&h=400&fit=crop',
        'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlrvyJSGfEHu6_qcXWKaMcArEe596KjO40RQ&s',
        'logo_hover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlrvyJSGfEHu6_qcXWKaMcArEe596KjO40RQ&s',
        'description' => 'Passion for Nutrition Since 1926'
    ],
    [
        'id' => 3,
        'name' => 'Premium Nuts',
        'image' => 'https://images.unsplash.com/photo-1608797178974-15b35a64ede9?w=600&h=400&fit=crop',
        'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxSKhzsrJZs8EUr2MKFkD4PqrqOy3XM_CTRw&s',
        'logo_hover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxSKhzsrJZs8EUr2MKFkD4PqrqOy3XM_CTRw&s',
        'description' => 'Organic Dry Fruits & Nuts'
    ]
];
?>

<style>
/* ======== Section Styling ======== */
.brands-section {
    background: #fafafa;
    padding: 50px 0;
}
.section-header {
    text-align: center;
    margin-bottom: 40px;
}
.section-header h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #222;
}
.section-header p {
    color: #666;
    font-size: 15px;
}

/* ======== Brand Card ======== */
.brand-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.4s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: relative;
    cursor: pointer;
}
.brand-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

/* ======== Image ======== */
.brand-image-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}
.brand-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    filter: brightness(0.8);
    transition: all 0.4s ease;
}
.brand-card:hover .brand-image {
    transform: scale(1.08);
    filter: brightness(1);
}

/* ======== Logo ======== */
.brand-logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90px;
    height: 90px;
    object-fit: contain;
    z-index: 2;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    padding: 10px;
    transition: 0.3s;
}
.brand-card:hover .brand-logo {
    transform: translate(-50%, -50%) scale(1.12);
}

/* ======== Overlay ======== */
.brand-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.4s ease;
}
.brand-card:hover .brand-overlay {
    opacity: 1;
}
.brand-overlay .btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 6px 18px;
    font-size: 13px;
    border-radius: 20px;
    transition: 0.3s;
}
.brand-overlay .btn:hover {
    background: #218838;
}

/* ======== Body ======== */
.brand-body {
    text-align: center;
    padding: 15px 10px 20px;
    background: #fff;
}
.brand-body h5 {
    font-weight: 600;
    color: #222;
}
.brand-body p {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
}
.brand-body .stars {
    color: #ffc107;
    font-size: 13px;
    margin-bottom: 8px;
}


/* Rating + Animation */
.rating {
    color: #ffc107;
    font-size: 13px;
    margin-top: 5px;
}
.fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
}
.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
<div class="container" style="margin-top: 40px;">
    <div class="header" style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        <h3 class="section-title" style="font-size: 24px; color: #111;">Grocery Brands</h3>
        <span style="font-size: 13px; color: #777;">Sponsored</span>
    </div>


     <div class="brands-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
        <?php foreach ($brands as $brand): ?>
            <div class="brand-card fade-in" data-bs-toggle="tooltip" title="Click to view <?php echo htmlspecialchars($brand['name']); ?>">
                <div class="brand-image-container">
                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(255,255,255,0.9); padding: 4px 10px; font-size: 11px; border-radius: 3px; color: #444;">Sponsored</span>
                    <img class="brand-image" src="<?php echo htmlspecialchars($brand['image']); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?>">
                    <img class="brand-logo" src="<?php echo htmlspecialchars($brand['logo']); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?> Logo">
                    <img class="brand-logo-hover" src="<?php echo htmlspecialchars($brand['logo_hover']); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?> Logo Hover">
                </div>
                <div style="padding: 15px; text-align: center;">
                    <h4 style="margin-bottom: 6px; font-size: 18px; color: #111;"><?php echo htmlspecialchars($brand['name']); ?></h4>
                    <div class="rating">
                        <?php 
                            $rating = round($brand['rating']);
                            for($i=1; $i<=5; $i++){
                                echo $i <= $rating ? '⭐' : '☆';
                            }
                        ?>
                        <span style="color:#666; font-size:12px;">(<?php echo $brand['rating']; ?>)</span>
                    </div>
                    <p style="font-size: 14px; color: #666;"><?php echo htmlspecialchars($brand['description']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Tooltip activation
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

// Fade-in on scroll animation
const fadeEls = document.querySelectorAll('.fade-in');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
});
fadeEls.forEach(el => observer.observe(el));
</script>
