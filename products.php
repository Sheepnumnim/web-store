<?php include('dbconnect.php');?>
<?php
$sql = "SELECT product_img, product_name FROM products";
if ($res = mysqli_query($conn, $sql)) {
    $count = 0;
    while ($row = mysqli_fetch_array($res)) { 
        $rows[$count] = $row;
        $count++;
    }
    mysqli_free_result($res); 
} else {
    echo "Cannot query.</br>";
}
?>
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
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700%7CPT+Serif:400,700' rel='stylesheet'
        type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href='css/clear.css' />
    <link rel="stylesheet" type="text/css" href='css/common.css' />
    <link rel="stylesheet" type="text/css" href='css/font-awesome.min.css' />
    <link rel="stylesheet" type="text/css" href='css/carouFredSel.css' />
    <link rel="stylesheet" type="text/css" href='css/prettyPhoto.css' />
    <link rel="stylesheet" type="text/css" href='css/sm-clean.css' />
    <link rel="stylesheet" type="text/css" href='style.css' />
    <link rel="stylesheet" type="text/css" href='css/mystyle.css' />

    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="css/nice-select.css" />
    <link rel="stylesheet" type="text/css" href="css/slicknav.min.css" />
    <link rel="stylesheet" type="text/css" href='css/style.css' />

    <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>                
                <script src="js/respond.min.js"></script>                
        <![endif]-->

</head>

<body class="page">

    <div class="myproducts">
        <i class="ti-close"></i>
        <div class="col-lg-10 offset-lg-1" style="position: absolute; top: 50%; transform: translateY(-50%);">
            <div class="clear"></div>
            <div class="product-slider owl-carousel">
                <?php
                        // echo "<div style=\"height: auto;\">";
                        // echo "<div class=\"col-lg-10 offset-lg-1\" style=\"background-color: blue;\">";
                        // echo "<div class=\"product-slider owl-carousel\">";
                        // foreach ($c_rows as $row) {
                        //     echo "<div class=\"product-item\">";
                        //     echo "<div class=\"pi-pic\">";
                        //     echo "<img src=\"images/no-photo.png\" alt=\"\">";
                        //     echo "</div>";
                        //     echo "</div>";
                        // }
                        // echo "</div>";
                        // echo "</div>";
                        // echo "</div>";
                    ?>
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="images/no-photo.png" alt="">
                    </div>
                </div>
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="images/our-client.jpg" alt="">
                    </div>
                </div>
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="images/no-photo.png" alt="">
                    </div>
                </div>
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="images/no-photo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="body-wrapper">
        <div class="content-1330 header-holder center-relative">
            <?php include('get_header.php'); ?>
            <?php include('get_nav.php'); ?>
        </div>

        <div id="content" class="site-content">
            <article>
                <div class="content-1330 center-relative">
                    <a class="mygrid">
                        hi
                    </a>
                    <div class="clear"></div>
                    <?php
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
                    ?>
                    <div class="button-group filters-button-group">
                        <div class="button is-checked" data-filter="*">All</div>
                        <?php
                            foreach ($g_rows as $row) {
                                echo "<div class=\"button\" data-filter=\"." . $row . "\">" . $row . "</div>";
                            }
                        ?>
                    </div>
                    <div class="grid" id="portfolio">
                        <div class="grid-sizer"></div>
                        <?php
                            foreach ($c_rows as $row) {
                                echo "<div class=\"grid-item element-item p_one_third "
                                    . strtolower($row['category_group'])
                                    . "\">";
                                echo "<a href=\"javascript:void(0)\">";
                                echo "<img src=\"uploads/categories/"
                                    . $row['category_img']
                                    . "\" alt=\"\">";
                                echo "<div class=\"mygrid portfolio-text-holder\">";
                                echo "<p>"
                                    . strtoupper($row['category_name'])
                                    . "</p></div></a></div>";
                            }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </article>
        </div>
        <button onclick="enableScroll()">enable</button>
    <button onclick="disableScroll()">disable</button>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <div style="height: auto; ">
            <div class="col-lg-10 offset-lg-1" style="background-color: blue; ">
                <div class="clear"></div>
                <div class="product-slider owl-carousel">
                    <?php
                        // echo "<div style=\"height: auto;\">";
                        // echo "<div class=\"col-lg-10 offset-lg-1\" style=\"background-color: blue;\">";
                        // echo "<div class=\"product-slider owl-carousel\">";
                        // foreach ($c_rows as $row) {
                        //     echo "<div class=\"product-item\">";
                        //     echo "<div class=\"pi-pic\">";
                        //     echo "<img src=\"images/no-photo.png\" alt=\"\">";
                        //     echo "</div>";
                        //     echo "</div>";
                        // }
                        // echo "</div>";
                        // echo "</div>";
                        // echo "</div>";
                    ?>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="images/no-photo.png" alt="">
                        </div>
                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="images/our-client.jpg" alt="">
                        </div>
                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="images/no-photo.png" alt="">
                        </div>
                    </div>
                    <div class="product-item">
                        <div class="pi-pic">
                            <img src="images/no-photo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Footer-->

        <?php include('get_footer.php'); ?>

        <!-- End .body-border -->
    </div>



    <!--Load JavaScript-->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <script src="js/bootstrap-4.3.1.min.js"></script> -->
    <script src="js/jquery.js"></script>
    <!-- <script src="js/jquery-3.4.1.js"></script> -->
    <script src='js/jquery.fitvids.js'></script>
    <script src='js/jquery.smartmenus.min.js'></script>
    <script src='js/imagesloaded.pkgd.js'></script>
    <script src='js/isotope.pkgd.js'></script>
    <script src='js/jquery.carouFredSel-6.0.0-packed.js'></script>
    <script src='js/jquery.mousewheel.min.js'></script>
    <script src='js/jquery.touchSwipe.min.js'></script>
    <script src='js/jquery.easing.1.3.js'></script>
    <script src='js/jquery.prettyPhoto.js'></script>
    <script src='js/jquery.ba-throttle-debounce.min.js'></script>
    <script src='js/jquery.nicescroll.min.js'></script>
    <script src='js/main.js'></script>

    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery.dd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main-fashi.js"></script>
</body>

</html>