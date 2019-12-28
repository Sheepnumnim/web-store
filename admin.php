<?php 
    include('dbconnect.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['submit']) {
            case 'cadd':
                echo "clicked padd </br>";
                include('dbAddCategory.php');
            break;
            case 'csave':
                echo "clicked csave </br>";
                include('dbUpdateCategory.php');
            break;
            case 'cdelete':
                echo "clicked cdelete </br>";
                include('dbDeleteCategory.php');
            break;
            case 'padd':
                echo "clicked padd </br>";
                include('dbAddProduct.php');
            break;
            case 'psave':
                echo "clicked psave </br>";
                include('dbUpdateProduct.php');
            break;
            case 'pdelete':
                echo "clicked pdelete </br>";
                include('dbDeleteProduct.php');
            break;
        }
        // header("Location: ".$_SERVER['PHP_SELF']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('get_headInclude.php');?>
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
                        $sql = "SELECT DISTINCT category_group FROM categories ORDER BY category_id DESC";
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
                            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control-file" id="caFile" name="categoryImg"></br>
                                <input type="text" class="form-control" id="caName" name="categoryName" maxlength="50" placeholder="Enter category name (limit 50 characters)" required></br>
                                <legend class="col-form-label">Category group</legend>
                                <div>
                                    <?php
                                        $count = 0;
                                        foreach($cGroupArray as $data) {
                                            echo "<div class=\"form-check\">";
                                            if($data == "Others") {
                                                echo "<input class=\"form-check-input\" type=\"radio\" id=\"caGroup".$count."\" name=\"categoryGroup_add\" value=\"".$data."\" checked>";
                                            } else {
                                                echo "<input class=\"form-check-input\" type=\"radio\" id=\"caGroup".$count."\" name=\"categoryGroup_add\" value=\"".$data."\">";
                                            }
                                            echo "<label class=\"form-check-label\" for=\"caGroup".$count."\">";
                                            echo $data;
                                            echo "</label> </div>";
                                            $count++;
                                        }
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="caGroup<?php echo $count;?>" name="categoryGroup_add" value="new group">
                                        <label class="form-check-label" for="caGroup<?php echo $count;?>">
                                            New group
                                        </label>
                                        <input type="text" class="form-control" id="caGroupInput" name="categoryGroupInput_add" maxlength="20" placeholder="New category group's name (limit 20 characters)">
                                    </div>
                                </div>
                                </br><button type="submit" class="btn btn-outline-light" id="cAdd" name="submit" value="cadd">Add category</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">All categories:</th>
                        <td>
                            <?php
                                $ccount = 0;
                                $path = "uploads/categories/";
                                $sql = "SELECT * FROM categories ORDER BY category_id DESC";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        // form
                                        echo "<div class=\"clear\"></div>";
                                        echo "<form onSubmit=\"return cvalidate()\" action=\"".htmlspecialchars($_SERVER['PHP_SELF'])."\" method=\"post\" id=\"cform".$row['category_id']."\" enctype=\"multipart/form-data\">";
                                        // hiddenid + categoryPos
                                        echo "<div class=\"form-row\">";
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"csId_hidden".$ccount."\" name=\"hiddenid\" value=\"".$row['category_id']."\">";
                                        echo "<input type=\"number\" class=\"form-control\" id=\"cPos".$row['category_id']."\" name=\"categoryPos\" disabled value=\"".$row['category_pos']."\" placeholder=\"Position\">";
                                        echo "</div>";
                                        // categoryName
                                        echo "<div class=\"col-8\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"cName".$row['category_id']."\" name=\"categoryName\" maxlength=\"50\" disabled value=\"".$row['category_name']."\" placeholder=\"Category name\" required>";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"csImage_hidden".$row['category_id']."\" name=\"hiddenimg\" value=\"".$path.$row['category_img']."\">";
                                        echo "<a href=\"javascript:;\" src=\"".$path.$row['category_img']."\" class=\"zoomable\" id=\"csImage".$row['category_id']."\">image</a>";
                                        echo "</div>";
                                        // btn edit
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"button\" class=\"btn btn-outline-light\" id=\"cEdit".$row['category_id']."\" value=\"edit\">";
                                        echo "<a href=\"javascript:;\" class=\"d-none\" id=\"cCancel".$row['category_id']."\">cancel</a>";
                                        echo "</div>";
                                        // btn delete
                                        echo "<div class=\"col-1\">";
                                        echo "<button type=\"submit\" class=\"btn btn-outline-light\" id=\"cDelete".$row['category_id']."\" name=\"submit\" value=\"cdelete\">delete</button>";
                                        echo "</div>"; 
                                        echo "</div>";
                                        // categoryGroup + categoryGroupInput
                                        echo "<div class=\"form-row form-group\">";
                                        echo "<div class=\"col d-none\" id=\"csGroup_div".$row['category_id']."\">";
                                        echo "<legend class=\"col-form-label\">Category group</legend>";
                                        $count = 0;
                                        foreach($cGroupArray as $data) {
                                            echo "<div class=\"form-check\">";
                                            if($data == $row['category_group']) {
                                                echo "<input class=\"form-check-input\" type=\"radio\" id=\"csGroup".$row['category_id'].$count."\" name=\"categoryGroup_show".$row['category_id']."\" value=\"".$data."\" checked>";
                                            } else {
                                                echo "<input class=\"form-check-input\" type=\"radio\" id=\"csGroup".$row['category_id'].$count."\" name=\"categoryGroup_show".$row['category_id']."\" value=\"".$data."\">";
                                            }
                                            echo "<label class=\"form-check-label\" for=\"csGroup".$row['category_id'].$count."\">";
                                            echo $data;
                                            echo "</label> </div>";
                                            $count++;
                                        }
                                        echo "<div class=\"form-check\">";
                                        echo "<input class=\"form-check-input\" type=\"radio\" id=\"csGroup".$row['category_id'].$count."\" name=\"categoryGroup_show".$row['category_id']."\" value=\"new group\">";
                                        echo "<label class=\"form-check-label\" for=\"csGroup".$row['category_id'].$count."\">";
                                        echo "New group";
                                        echo "</label>";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"csGroupInput".$row['category_id']."\" name=\"categoryGroupInput".$row['category_id']."\" maxlength=\"20\" placeholder=\"New category group's name (limit 20 characters)\">";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        // categoryImg
                                        echo "<div class=\"form-row form-inline\">";
                                        echo "<div class=\"col\">";
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"csFile".$row['category_id']."\" name=\"categoryImg\">";
                                        echo "</div>";
                                        // btn save
                                        echo "<div class=\"col-1\">";
                                        echo "<button type=\"submit\" class=\"btn btn-outline-light d-none\" id=\"cSave".$row['category_id']."\" name=\"submit\" value=\"csave\">save</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "<hr>";
                                        $ccount++;
                                    }
                                    echo "<input type=\"hidden\" id=\"hidden_ccount\" name=\"hiddencount\" value=\"".$ccount."\">";
                                    echo "<input type=\"hidden\" id=\"hidden_csubmit\" name=\"hiddensubmit\" value=\"\">";
                                    echo "<input type=\"hidden\" id=\"hidden_cid\" value=\"\">";
                                    echo "<input type=\"hidden\" id=\"hidden_cpos\" value=\"\">";
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
                            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control-file" id="paFile" name="productImg"></br>
                                <input type="text" class="form-control" id="paName" name="productName" placeholder="Enter product name (limit 50 character)"></br>
                                <textarea class="form-control" id="paDesc" name="productDesc" rows="3" placeholder="Enter product description  (limit 100 character) (optional)"></textarea>
                                <label class="col-form-label">Add to category</label>
                                <?php
                                    $sql = "SELECT * FROM categories ORDER BY category_id DESC";
                                    if ($res = mysqli_query($conn, $sql)) {
                                        while ($row = mysqli_fetch_array($res)) { 
                                            echo "<div class=\"form-check\">";
                                            echo "<input class=\"form-check-input\" type=\"radio\" id=\"paCategory".$row['category_id']."\" name=\"productCategory\" value=". $row['category_id'] ." checked>";
                                            echo "<label class=\"form-check-label\" for=\"paCategory". $row['category_id'] ."\">";
                                            echo $row['category_name']; 
                                            echo "</label>";
                                            echo "</div>";
                                        }
                                        mysqli_free_result($res); 
                                    } else {
                                        echo "Cannot query.</br>";
                                    }
                                ?>
                                </br><button type="submit" class="btn btn-outline-light" value="padd" name="submit">Add product</button>
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
                                        echo "<form action=\"".htmlspecialchars($_SERVER['PHP_SELF'])."\" method=\"post\" id=\"pForm".$row['product_id']."\" enctype=\"multipart/form-data\">";
                                        echo "<div class=\"form-row\">";
                                        // hiddenid + productName
                                        echo "<div class=\"col-6\">";
                                        echo "<input type=\"hidden\" id=\"psId_hidden".$pcount."\" name=\"hiddenid\" value=\"".$row['product_id']."\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"psName".$row['product_id']."\" name=\"productName\" disabled value=\"".$row['product_name']."\" placeholder=\"Product name\">";
                                        echo "</div>";
                                        // categoryName
                                        echo "<div class=\"col-2\">";
                                        echo "<select class=\"custom-select\" id=\"psCategory".$row['product_id']."\" name=\"categoryName\" disabled=\"disabled\">";
                                        foreach ($cNameArray as $option) {
                                            if($option == $row['category_name']) {
                                                echo "<option value=\"".$option."\" selected>".$option."</option>";
                                            } else {
                                                echo "<option value=\"".$option."\">".$option."</option>";
                                            }
                                        }
                                        echo "</select>";
                                        echo "</div>";
                                        // hiddenfav
                                        echo "<div class=\"col-1\">";
                                        echo "<span href=\"\" class=\"myfav dashicons dashicons-heart\" id=\"psFav".$row['product_id']."\"></span>";
                                        echo "<input type=\"hidden\" id=\"psFav_hidden".$row['product_id']."\" name=\"hiddenfav\" value=\"".$row['product_fav']."\">";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"psImage_hidden".$row['product_id']."\" name=\"hiddenimg\" value=\"".$path.$row['product_img']."\">";
                                        echo "<a href=\"javascript:;\" src=\"".$path.$row['product_img']."\" class=\"zoomable\" id=\"psImage".$row['product_id']."\">image</a>";
                                        echo "</div>";
                                        // btn edit
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"button\" class=\"btn btn-outline-light\" id=\"pEdit".$row['product_id']."\" value=\"edit\">";
                                        // cancel link
                                        echo "<a href=\"javascript:;\" class=\"d-none\" id=\"pCancel".$row['product_id']."\">cancel</a>";
                                        echo "</div>";
                                        // btn delete
                                        echo "<div class=\"col-1\">";
                                        echo "<button type=\"submit\" class=\"btn btn-outline-light\" id=\"pDelete".$row['product_id']."\" name=\"submit\" value=\"pdelete\">delete</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        // productImg
                                        echo "<div style=\"padding-top: 15px;\" class=\"form-row form-inline\">";
                                        echo "<div class=\"col\">";
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"psFile".$row['product_id']."\" name=\"productImg\">"; 
                                        echo "</div>";
                                        // btn save
                                        echo "<div class=\"col-1\">";
                                        echo "<button type=\"submit\" class=\"btn btn-outline-light d-none\" id=\"pSave".$row['product_id']."\" name=\"submit\" value=\"psave\">save</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "<hr>";
                                        $pcount++;
                                    }
                                    echo "<input type=\"hidden\" id=\"hidden_pcount\" name=\"hiddencount\" value=\"".$pcount."\">";
                                    echo "<input type=\"hidden\" id=\"hidden_pfav\" value=\"".$pcount."\">";
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
    <script>
        $('input').on('keydown', function(event) {
            var x = event.which;
            if (x === 13) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>

<?php
?>