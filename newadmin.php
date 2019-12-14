<?php include('dbconnect.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href='testcss.css' />
    <link href="//s.w.org/wp-includes/css/dashicons.css?20150710" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                    <tr>
                        <th style="width: 20%" scope="row">Add category:</th>
                        <td style="width: 80%">
                            <form action="dbAddCategory.php" method="post" enctype="multipart/form-data" onsubmit="return validate();">
                                <input type="file" class="form-control-file" name="categoryImg" id="categoryImg"></br>
                                <input type="text" class="form-control" name="categoryName" id="categoryName" maxlength="50" placeholder="Enter category name (limit 50 characters)"></br>
                                <input type="text" class="form-control" name="categoryGroup" id="categoryGroup" maxlength="20" placeholder="Enter group of category (limit 20 characters)"></br>
                                <div class="invalid-feedback">
                                    Please enter category name and group.
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
                                        echo "<form action=\"<?php echo $_SERVER[PHP_SELF]; ?>\" method=\"post\">";
                                        echo "<div class=\"form-row\">";
                                        // hiddenid + categoryPos
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_cid".$ccount."\" name=\"hiddenid\" value=\"".$row['category_id']."\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"cPos".$row['category_id']."\" name=\"categoryPos\" disabled value=\"".$row['category_pos']."\">";
                                        echo "</div>";
                                        // categoryGroup
                                        echo "<div class=\"col-3\">";
                                        echo "<input type=\"text\" class=\"form-control\"id=\"cGroup".$row['category_id']."\" name=\"categoryGroup\"  maxlength=\"20\" disabled value=\"".$row['category_group']."\">";
                                        echo "</div>";
                                        // categoryName
                                        echo "<div class=\"col-5\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"cName".$row['category_id']."\" name=\"categoryName\" maxlength=\"50\" disabled value=\"".$row['category_name']."\">";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_cimg".$row['category_id']."\" name=\"hiddenimg\" value=\"".$path.$row['category_img']."\">";
                                        // echo $ccount." ".$path.$row['category_img'];
                                        echo "<a href=\"".$path.$row['category_img']."\" id=\"cimage".$row['category_id']."\">image</a>";
                                        echo "</div>";
                                        echo "<div class=\"col-1\">";
                                        echo "<a href=\"javascript:;\" id=\"cedit".$row['category_id']."\">edit</a>";
                                        echo "</div>";
                                        echo "<div class=\"col-1\">";
                                        echo "<a href=\"javascript:;\" id=\"cdelete".$row['category_id']."\">delete</a>";
                                        echo "</div>";
                                        // categoryImg
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"cfile".$row['category_id']."\" name=\"categoryImg\">";
                                        echo "</div> </form>";
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
                <button class="btn btn-link collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Product
                </button>
            </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <table class="table table-striped table-dark table-responsive-xl">
                <tbody>
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
                                $sql = "SELECT * FROM products";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        // form
                                        echo "<form action=\"<?php echo $_SERVER[PHP_SELF]; ?>\" method=\"post\">";
                                        echo "<div class=\"form-row\">";
                                        // hiddenid + productName
                                        echo "<div class=\"col-8\">";
                                        echo "<input type=\"hidden\" id=\"hidden_pid".$pcount."\" name=\"hiddenid\" value=\"".$row['product_id']."\">";
                                        echo "<input type=\"text\" class=\"form-control\" id=\"pName".$row['product_id']."\" name=\"productName\" disabled value=\"".$row['product_name']."\">";
                                        echo "</div>";
                                        // hiddenfav
                                        echo "<div class=\"col-1\">";
                                        echo "<span href=\"\" class=\"favme dashicons dashicons-heart\" id=\"cFav1\"></span>";
                                        echo "<input type=\"hidden\" id=\"hiddenfav".$row['product_id']."\" name=\"hiddenfav\" value=\"0\">";
                                        echo "</div>";
                                        // hiddenimg
                                        echo "<div class=\"col-1\">";
                                        echo "<input type=\"hidden\" id=\"hidden_pimg".$row['product_id']."\" name=\"hiddenimg\" value=\"".$path.$row['product_img']."\">";
                                        echo "<a href=\"".$path.$row['product_img']."\" id=\"pimage".$row['product_id']."\">image</a>";
                                        echo "</div>";
                                        echo "<div class=\"col-1\">";
                                        echo "<a href=\"javascript:;\" id=\"pedit".$row['product_id']."\">edit</a>";
                                        echo "</div>";
                                        echo "<div class=\"col-1\">";
                                        echo "<a href=\"javascript:;\" id=\"pdelete".$row['product_id']."\">delete</a>";
                                        echo "</div>";
                                        // productImg
                                        echo "<input type=\"file\" class=\"form-control-file d-none\" id=\"pfile".$row['product_id']."\" name=\"productImg\">";
                                        echo "</div> </form>";
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
    <script src="testjs.js"></script>
    <script>
        $(document).ready(function(){
            var $ccount = $("#hidden_ccount").val();
            for(var i=0; i<parseInt($ccount, 10); i++) {
                var obj_name = "#hidden_cid" + i;
                let obj_id = $(obj_name).val();
                $("#cedit" + obj_id).click(function(){
                    if($(this).text() == "edit"){
                        $(this).text("save");
                        $("#cPos" + obj_id).removeAttr("disabled");
                        $("#cGroup" + obj_id).removeAttr("disabled");
                        $("#cName" + obj_id).removeAttr("disabled");
                        $("#cimage" + obj_id).text("change image");
                        $("#cimage" + obj_id).attr("href", "javascript:;");
                        // $("#cimage" + obj_id).addClass("disabled");
                        $("#cfile" + obj_id).removeClass("d-none");
                        console.log("clicked: " + obj_id);
                    } else {
                        $(this).text("edit");
                        $("#cPos" + obj_id).attr("disabled", "true");
                        $("#cGroup" + obj_id).attr("disabled", "true");
                        $("#cName" + obj_id).attr("disabled", "true");
                        $("#cimage" + obj_id).text("image");
                        $("#cimage" + obj_id).attr("href", $("#hidden_cimg" + obj_id).val());
                        // $("#cimage" + obj_id).removeClass("disabled");
                        $("#cfile" + obj_id).addClass("d-none");
                        console.log("clicked: " + obj_id);
                    }
                });
            }

            var $pcount = $("#hidden_pcount").val();
            for(var i=0; i<parseInt($pcount, 10); i++) {
                var obj_name = "#hidden_pid" + i;
                let obj_id = $(obj_name).val();
                $("#pedit" + obj_id).click(function(){
                    if($(this).text() == "edit"){
                        $(this).text("save");
                        $("#pName" + obj_id).removeAttr("disabled");
                        $("#pimage" + obj_id).text("change image");
                        $("#pimage" + obj_id).attr("href", "javascript:;");
                        // $("#pimage" + obj_id).addClass("disabled");
                        $("#pfile" + obj_id).removeClass("d-none");
                        // $("#cFav1").addClass("favme");
                        console.log("clicked: " + obj_id);
                    } else {
                        $(this).text("edit");
                        $("#pName" + obj_id).attr("disabled", "true");
                        $("#pimage" + obj_id).text("image");
                        $("#pimage" + obj_id).attr("href", $("#hidden_pimg" + obj_id).val());
                        // $("#pimage" + obj_id).removeClass("disabled");
                        $("#pfile" + obj_id).addClass("d-none");
                        // $("#cFav1").removeClass("favme");
                        console.log("clicked: " + obj_id);
                    }
                });
            }
        });
    </script>
</body>
</html>