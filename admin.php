<?php include('dbconnect.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/mystyle.css" type="text/css">
    <link rel="stylesheet" href="//s.w.org/wp-includes/css/dashicons.css?20150710" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <title>Document</title>
</head>
<body class="container bg-dark">
    <h1 class="text-light" id="top">Icon-Perfect Admin</h1>
    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>
    
    <div class="accordion" id="accordionExample">

        <!-- category -->
        <div class="card bg-dark">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Category
                </button>
            </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <table class="table table-striped table-dark table-responsive-xl">
                <tbody>
                    <?php
                        $sql = "SELECT DISTINCT category_group FROM categories";
                        $cGroupArray = array();
                        if ($res = mysqli_query($conn, $sql)) {
                            while ($row = mysqli_fetch_array($res)) {
                                $cGroupArray[] = $row['category_group'];
                            }
                            mysqli_free_result($res);
                        } else {
                            echo "Cannot query.</br>";
                        }
                    ?>
                    <tr>
                        <th style="width: 20%" scope="row">Add category:</th>
                        <td style="width: 80%">
                            <form action="dbUpdateCategory.php" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control-file" name="categoryImg" id="categoryImg"></br>
                                <input type="text" class="form-control" name="categoryName" id="categoryName" maxlength="50" placeholder="Enter category name (limit 50 characters)" required></br>
                                <legend class="col-form-label">Category group</legend>
                                <div>
                                    <?php
                                        $count = 0;
                                        foreach($cGroupArray as $data) {
                                            echo "<div class=\"form-check\">";
                                            if($data == "Others") {
                                                echo "<input class=\"form-check-input\" type=\"radio\" name=\"categoryGroup\" id=\"addCGroup".$count."\" value=\"".$data."\" checked>";
                                            } else {
                                                echo "<input class=\"form-check-input\" type=\"radio\" name=\"categoryGroup\" id=\"addCGroup".$count."\" value=\"".$data."\">";
                                            }
                                            echo "<label class=\"form-check-label\" for=\"addCGroup".$count."\">";
                                            echo ucfirst($data);
                                            echo "</label> </div>";
                                            $count++;
                                        }
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="categoryGroup" id="addCGroup<?php echo $count;?>" value="new group">
                                        <label class="form-check-label" for="addCGroup<?php echo $count;?>">
                                            New group
                                        </label>
                                        <input type="text" class="form-control" name="newcGroup" maxlength="20" placeholder="New category group's name (limit 20 characters)">
                                    </div>
                                </div>
                                </br><input type="submit" class="btn btn-outline-light" value="Add category" name="submit">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">All categories:</th>
                        <td>
                            <?php
                                $ccount = 0;
                                $path = "uploads/categories/";
                                $sql = "SELECT * FROM categories";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        // form
                                        echo "<div class=\"clear\"></div>";
                                        echo "<form action=\"#\" method=\"post\" id=\"cForm".$row['category_id']."\" enctype=\"multipart/form-data\">";
                                        // hiddenid + categoryPos
                                        echo "<div class=\"form-row\">";
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_cid".$ccount."\" name=\"hiddenid\" value=\"".$row['category_id']."\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"cPos".$row['category_id']."\" name=\"categoryPos\" disabled value=\"".$row['category_pos']."\" placeholder=\"Position\">";
                                        echo "</div>";
                                        // categoryName
                                        echo "<div class=\"col-8\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"cName".$row['category_id']."\" name=\"categoryName\" maxlength=\"50\" disabled value=\"".$row['category_name']."\" placeholder=\"Category name\" required>";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_cimg".$row['category_id']."\" name=\"hiddenimg\" value=\"".$path.$row['category_img']."\">";
                                        echo "<a href=\"javascript:;\" src=\"".$path.$row['category_img']."\" class=\"zoomable\" id=\"cimage".$row['category_id']."\">image</a>";
                                        echo "</div>";
                                        // btn edit
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"button\" class=\"btn btn-outline-light\" id=\"cedit".$row['category_id']."\" value=\"edit\">";
                                        echo "<a href=\"javascript:;\" class=\"d-none\" id=\"ccancel".$row['category_id']."\">cancel</a>";
                                        echo "</div>";
                                        // btn delete
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"submit\" class=\"btn btn-outline-light\" id=\"cdelete".$row['category_id']."\" name=\"submit\" value=\"delete\">";
                                        echo "</div>"; 
                                        echo "</div>";
                                        // categoryGroup
                                        echo "<div class=\"form-row form-group\">";
                                        echo "<div class=\"col d-none\" id=\"hiddengroup".$row['category_id']."\">";
                                        // echo "<input type=\"text\" class=\"form-control\"id=\"cGroup".$row['category_id']."\" name=\"categoryGroup\"  maxlength=\"20\" disabled value=\"".$row['category_group']."\"placeholder=\"Category group\">";
                                        echo "<legend class=\"col-form-label\">Category group</legend>";
                                        $count = 0;
                                        foreach($cGroupArray as $data) {
                                            echo "<div class=\"form-check\">";
                                            if($data == $row['category_group']) {
                                                echo "<input class=\"form-check-input\" type=\"radio\" name=\"categoryGroup\" id=\"cGroup".$count."\" value=\"".$data."\" checked>";
                                            } else {
                                                echo "<input class=\"form-check-input\" type=\"radio\" name=\"categoryGroup\" id=\"cGroup".$count."\" value=\"".$data."\">";
                                            }
                                            echo "<label class=\"form-check-label\" for=\"cGroup".$count."\">";
                                            echo ucfirst($data);
                                            echo "</label> </div>";
                                            $count++;
                                        }
                                        echo "<div class=\"form-check\">";
                                        echo "<input class=\"form-check-input\" type=\"radio\" name=\"categoryGroup\" id=\"cGroup".$count."\" value=\"new group\">";
                                        echo "<label class=\"form-check-label\" for=\"cGroup".$count."\">";
                                        echo "New group";
                                        echo "</label>";
                                        echo "<input type=\"text\" class=\"form-control\" name=\"newcGroup\" maxlength=\"20\" placeholder=\"New category group's name (limit 20 characters)\">";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        // categoryImg
                                        echo "<div class=\"form-row form-inline\">";
                                        echo "<div class=\"col\">";
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"cfile".$row['category_id']."\" name=\"categoryImg\">";
                                        echo "</div>";
                                        // btn save
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"submit\" class=\"btn btn-outline-light d-none\" id=\"csave".$row['category_id']."\" name=\"submit\" value=\"save\">";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "<hr>";
                                        $ccount++;
                                    }
                                    echo "<input type=\"hidden\" id=\"hidden_ccount\" name=\"hiddencount\" value=\"".$ccount."\">";
                                    mysqli_free_result($res); 
                                } else {
                                    echo "Cannot query.</br>";
                                }
                            ?>
                            
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- product -->
        <div class="card bg-dark">
            <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="fault" aria-controls="collapseTwo">
                Product
                </button>
            </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <table class="table table-striped table-dark table-responsive-xl">
                <tbody>
                    <?php
                        $sql = "SELECT category_name FROM categories";
                        $cNameArray = array();
                        if ($res = mysqli_query($conn, $sql)) {
                            while ($row = mysqli_fetch_array($res)) {
                                $cNameArray[] = $row['category_name'];
                            }
                            mysqli_free_result($res);
                        } else {
                            echo "Cannot query.</br>";
                        }
                    ?>
                    <tr>
                        <th style="width: 20%" scope="row">Add product:</th>
                        <td style="width: 80%">
                            <form action="dbAddProduct.php" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control-file" name="productImg" id="productImg"></br>
                                <input type="text" class="form-control" name="productName" id="productName" placeholder="Enter product name (limit 50 character)"></br>
                                <textarea class="form-control" name="productDesc" id="productDesc" rows="3" placeholder="Enter product description  (limit 100 character) (optional)"></textarea>
                                <label class="col-form-label">Add to category</label>
                                <?php
                                    $sql = "SELECT * FROM categories";
                                    if ($res = mysqli_query($conn, $sql)) {
                                        while ($row = mysqli_fetch_array($res)) { 
                                            echo "<div class=\"form-check\">";
                                            echo "<input class=\"form-check-input\" type=\"radio\" name=\"category_id\" id=". $row['category_id'] ." value=". $row['category_id'] ." checked>";
                                            echo "<label class=\"form-check-label\" for=". $row['category_id'] .">";
                                            echo ucfirst($row['category_name']); 
                                            echo "</label>";
                                            echo "</div>";
                                        }
                                        mysqli_free_result($res); 
                                    } else {
                                        echo "Cannot query.</br>";
                                    }
                                ?>
                                </br><input type="submit" class="btn btn-outline-light" value="Add product" name="submit">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">All products:</th>
                        <td>
                            <?php
                                $pcount = 0;
                                $path = "uploads/products/";
                                $sql = "SELECT product_id, product_name, product_img, product_fav, category_name FROM products, categories AS c WHERE products.category_id = c.category_id";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        // form
                                        echo "<div class=\"clear\"></div>";
                                        echo "<form action=\"#\" method=\"post\" id=\"pForm".$row['product_id']."\" enctype=\"multipart/form-data\">";
                                        echo "<div class=\"form-row\">";
                                        // hiddenid + productName
                                        echo "<div class=\"col-6\">";
                                        echo "<input type=\"hidden\" id=\"hidden_pid".$pcount."\" name=\"hiddenid\" value=\"".$row['product_id']."\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"pName".$row['product_id']."\" name=\"productName\" disabled value=\"".$row['product_name']."\" placeholder=\"Product name\">";
                                        echo "</div>";
                                        // categoryName
                                        echo "<div class=\"col-2\">";
                                        echo "<select class=\"custom-select\" id=\"pcName".$row['product_id']."\" name=\"categoryName\" disabled=\"disabled\">";
                                        foreach ($cNameArray as $option) {
                                            if($option == $row['category_name']) {
                                                echo "<option value=\"".$option."\" selected>".ucfirst($option)."</option>";
                                            } else {
                                                echo "<option value=\"".$option."\">".ucfirst($option)."</option>";
                                            }
                                        }
                                        echo "</select>";
                                        echo "</div>";
                                        // hiddenfav
                                        echo "<div class=\"col-1\">";
                                        echo "<span href=\"\" class=\"myfav dashicons dashicons-heart\" id=\"pFav".$row['product_id']."\"></span>";
                                        echo "<input type=\"hidden\" id=\"hiddenfav".$row['product_id']."\" name=\"hiddenfav\" value=\"".$row['product_fav']."\">";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_pimg".$row['product_id']."\" name=\"hiddenimg\" value=\"".$path.$row['product_img']."\">";
                                        echo "<a href=\"javascript:;\" src=\"".$path.$row['product_img']."\" class=\"zoomable\" id=\"pimage".$row['product_id']."\">image</a>";
                                        echo "</div>";
                                        // btn edit
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"button\" class=\"btn btn-outline-light\" id=\"pedit".$row['product_id']."\" value=\"edit\">";
                                        // cancel link
                                        echo "<a href=\"javascript:;\" class=\"d-none\" id=\"pcancel".$row['product_id']."\">cancel</a>";
                                        echo "</div>";
                                        // btn delete
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"submit\" class=\"btn btn-outline-light\" id=\"pdelete".$row['product_id']."\" name=\"submit\" value=\"delete\">";
                                        echo "</div>";
                                        echo "</div>";
                                        // productImg
                                        echo "<div style=\"padding-top: 15px;\" class=\"form-row form-inline\">";
                                        echo "<div class=\"col\">";
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"pfile".$row['product_id']."\" name=\"productImg\">"; 
                                        echo "</div>";
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"submit\" class=\"btn btn-outline-light d-none\" id=\"psave".$row['product_id']."\" name=\"submit\" value=\"save\">";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "<hr>";
                                        $pcount++;
                                    }
                                    echo "<input type=\"hidden\" id=\"hidden_pcount\" name=\"hiddenfav\" value=\"".$pcount."\">";
                                    mysqli_free_result($res); 
                                } else {
                                    echo "Cannot query.</br>";
                                }
                            ?>
                            
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- config -->
        <div class="card bg-dark">
            <div class="card-header" id="headingThree">
            <h2 class="mb-0">
                <button class="btn btn-link collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Config & database information
                </button>
            </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <table class="table table-striped table-dark table-responsive-xl">
                <tbody>
                    <tr>
                        <th style="width: 20%" scope="row">Real path:</th>
                        <td style="width: 80%">
                            <?php
                                $realpath = realpath(__FILE__);
                                echo $realpath;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Dir name:</th>
                        <td>
                            <?php
                                $path = dirname($realpath);
                                $path = str_replace("\\", "/", $path) . "/uploads";
                                echo $path;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">File in /uploads:</th>
                        <td>
                            <?php
                                $files = scandir($path);
                                print_r($files);
                            ?>
                        </td>
                    </tr>
                </tbody>
                </table>

            </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

    </div>
    <div style="bottom:65px; right:20px; position:fixed;"><a href="#top" target="_top"><img src="images/prettyPhoto/arrow-up-icon.png" alt="arrow-up-icon" width="40" height="40"/></a></div>
    <div style="bottom:20px; right:20px; position:fixed;"><a href="#bottom" target="_top"><img src="images/prettyPhoto/arrow-down-icon.png" alt="arrow-down-icon" width="40" height="40"/></a></div>
    <div id="bottom"></div>

    <script src="js/myscript.js"></script>
    <script src="http://static.tumblr.com/xz44nnc/o5lkyivqw/jquery-1.3.2.min.js"></script>
</body>
</html>