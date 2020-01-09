<?php include 'dbconnect.php'; ?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <title>Icon Perfect : A Specialist of Premium Products</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Template by Dry Themes" />
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP" />
    <meta name="author" content="DryThemes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700%7CPT+Serif:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css"  href='css/clear.css' />
    <link rel="stylesheet" type="text/css"  href='css/common.css' />
    <link rel="stylesheet" type="text/css"  href='css/font-awesome.min.css' />
    <link rel="stylesheet" type="text/css"  href='css/carouFredSel.css' />
    <link rel="stylesheet" type="text/css"  href='css/prettyPhoto.css' />
    <link rel="stylesheet" type="text/css"  href='css/sm-clean.css' />
    <link rel="stylesheet" type="text/css"  href='style.css' />
    
    <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>
                <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body class="page">

    <div class="body-wrapper">
        <div class="content-1330 header-holder center-relative">
            <?php include 'get_header.php';?>
            <?php include 'get_nav.php';?>
        </div>

        <div id="content" class="site-content">
            <article>
                <div class="content-1330 center-relative">
                    <div class="mytitle">
                        ICON PERFECT - A Specialist Of Premium Products
                    </div>
                    <p>&nbsp;</p>
                    <div class="mydesc">
                        Icon Perfect Co., Ltd. has been involved in gift and premium business since 2008. Our philosophy
                        is to provide high quality to our valued clients professionally and ethically. We designs,
                        manufactures, imports and trades special gift that may suit your company requirements.
                    </div>
                    <div>
                        <a href="about.php">read more...</a>
                    </div>
                    <div class="clear"></div>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <div class="mytitle">
                        Highlight Products
                    </div>
                    <p>&nbsp;</p>
                    <?php
/*
// get category
$c_rows = array();
$sql = "SELECT DISTINCT c.category_id, category_name, category_img, category_pos, category_group
    FROM categories c, products p
    WHERE c.category_id=p.category_id
    ORDER BY category_pos ASC";
if ($res = mysqli_query($conn, $sql)) {
    $count = 0;
    while ($row = mysqli_fetch_array($res)) {
        $c_rows[$count] = $row;
        $count++;
    }
    mysqli_free_result($res);
} else {
    echo "Cannot query.</br>";
}

// get group of category
$g_rows = array();
$count = 0;
foreach ($c_rows as $row) {
    $g_rows[$count] = strtolower($row['category_group']);
    $count++;
}
*/

$p_rows = array();
$count = 0;
$sql = "SELECT * FROM products WHERE product_fav=1";
if ($res = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($res)) {
        $p_rows[$count] = $row;
        $count++;
    }
} else {
    echo "Cannot query.</br>";
}
?>

                    <div class="grid" id="portfolio">
                        <div class="grid-sizer"></div>
                        <?php
foreach ($p_rows as $row) {
    echo "<div class=\"grid-item element-item p_one_third "
    . strtolower($row['category_id'])
        . "\">";
    echo "<a href=\"uploads/products/"
        . $row['product_img']
        . "\">";
    echo "<img src=\"uploads/products/"
        . $row['product_img']
        . "\">"
        . "alt=\"\">";
    echo "<div class=\"portfolio-text-holder\">";
    echo "<p>"
    . strtoupper($row['product_name'])
        . "</p>";
    echo "</div></a></div>";
}
?>
                    </div>
                    <div class="clear"></div>
                </div>
            </article>
        </div>

        <!--Footer-->

        <?php include 'get_footer.php';?>

        <!-- End .body-border -->
    </div>

    <!--Load JavaScript-->
    <script src="js/jquery.js"></script>
    <script src='js/jquery.fitvids.js'></script>
    <script src='js/jquery.smartmenus.min.js'></script>
    <script src='js/bootstrap-4.3.1.min.js'></script>
    <script src='js/imagesloaded.pkgd.js'></script>
    <script src='js/isotope.pkgd.js'></script>
    <script src='js/popper.min.js'></script>
    <script src='js/jquery.carouFredSel-6.0.0-packed.js'></script>
    <script src='js/jquery.mousewheel.min.js'></script>
    <script src='js/jquery.touchSwipe.min.js'></script>
    <script src='js/jquery.easing.1.3.js'></script>
    <script src='js/jquery.prettyPhoto.js'></script>
    <script src='js/jquery.ba-throttle-debounce.min.js'></script>
    <script src='js/jquery.nicescroll.min.js'></script>
    <script src='js/main.js'></script>
</body>

</html>

<?php
mysqli_close($conn);
?>