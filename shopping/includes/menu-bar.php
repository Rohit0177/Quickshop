<style>
/* Keep navbar items in a single line and enable horizontal scroll on small screens */
.navbar-nav {
    flex-wrap: nowrap !important;
    overflow-x: auto;
    white-space: nowrap;
    display: flex;
}

.navbar-nav > li {
    float: none;
    display: inline-block;
}

.navbar-nav > li > a {
    padding: 0 15px;
    font-size: 16px;
}

@media (max-width: 1200px) {
    .navbar-header { display: none; }
    .navbar-collapse {
        display: block !important;
        height: auto !important;
        padding: 0;
        border: none;
        box-shadow: none;
    }
    .navbar-nav {
        margin: 0;
    }
}
</style>
<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse in" id="mc-horizontal-menu-collapse" style="display:block !important;">
                    <div class="nav-outer">
                        <ul class="nav navbar-nav">
                            <li class="active dropdown yamm-fw">
                                <a href="index.php" data-hover="dropdown" class="dropdown-toggle">Home</a>
                            </li>
                            <?php
                            $sql = mysqli_query($con, "select id,categoryName from category limit 6");
                            while ($row = mysqli_fetch_array($sql)) {
                            ?>
                            <li class="dropdown yamm">
                                <a href="category.php?cid=<?php echo $row['id']; ?>"> <?php echo $row['categoryName']; ?></a>
                            </li>
                            <?php } ?>
                            <li class="dropdown yamm">
                                <a href="admin/" style="color:#000"> Admin Login</a>
                            </li>
                        </ul><!-- /.navbar-nav -->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>