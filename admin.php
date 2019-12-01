<?php include('dbconnect.php');?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function validate() {
            var ename = document.getElementById( "categoryName" );
            if( ename.value == "" ) {
                ename.setAttribute("class", "form-control is-invalid");
                return false;
            } else {
                return true;
            }
            var egroup = document.getElementById( "categoryGroup" );
            if( egroup.value == "" ) {
                egroup.setAttribute("class", "form-control is-invalid");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body class="container bg-dark">
    <h1 class="text-light">Icon-Perfect Admin</h1>
    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>

    <div class="accordion" id="accordionExample">

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
                <table class="table table-striped table-dark">
                    <caption>Categories</caption>
                    <tr>
                        <th scope="row">All categories:</th>
                        <td>
                            <?php
                                $sql = "SELECT * FROM categories";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        echo "id: " . $row['category_id'] . " || "; 
                                        echo "name: " . $row['category_name'] . " || "; 
                                        echo "img file name: " . $row['category_img'] . " || ";  
                                        echo "position: " . $row['category_pos'] . " || ";
                                        echo "group: " . $row['category_group'] . "</br>";
                                    }
                                    mysqli_free_result($res); 
                                } else {
                                    echo "Cannot query.</br>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-3" scope="row">Add category:</th>
                        <td class="col-9">
                            <form action="dbAddCategory.php" method="post" enctype="multipart/form-data" onsubmit="return validate();">
                                <input type="file" class="form-control-file" name="categoryImg" id="categoryImg"></br>
                                <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Enter category name..."></br>
                                <input type="text" class="form-control" name="categoryGroup" id="categoryGroup" placeholder="Enter group of category..."></br>
                                <div class="invalid-feedback">
                                    Please enter category name and group.
                                </div>
                                </br><input type="submit" class="btn btn-outline-light" value="Add category" name="submit">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Remove category:</th>
                        <td>
                            <form action="dbRemoveCategory.php" method="post" enctype="multipart/form-data">
                            <?php
                                $sql = "SELECT * FROM categories";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        echo "<div class=\"custom-control custom-checkbox\">";
                                        echo "<input class=\"custom-control-input\" type=\"checkbox\" id=\""
                                            .$row['category_id']."\" value=\""
                                            .$row['category_id']."\" aria-label=\"...\" name=\"ckeck_cat_id[]\">";
                                        echo "<label class=\"custom-control-label\" for=\"".$row['category_id']."\">"
                                            ."id: " . $row['category_id'] . " || "
                                            ."name: " . ucfirst($row['category_name']) . " || "
                                            ."img file name: " . $row['category_img'] . " || "
                                            ."position: " . $row['category_pos'] . "</br>"
                                            ."</label>";
                                        echo "</div>";
                                    }
                                    mysqli_free_result($res); 
                                } else {
                                    echo "Cannot query.</br>";
                                }
                            ?>
                                </br><input type="submit" class="btn btn-outline-light" value="Remove category" name="submit">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Set categories arranging: </br>(show in products page)</th>
                        <td>
                            developing...
                        </td>
                    </tr>
                </table>
            </div>
            </div>
        </div>

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
                <table class="table table-striped table-dark">
                    <caption>Products</caption>
                    <tr>
                        <th scope="row">All products:</th>
                        <td>
                            <?php
                                $sql = "SELECT * FROM products";
                                if ($res = mysqli_query($conn, $sql)) {
                                    while ($row = mysqli_fetch_array($res)) { 
                                        echo "id: " . $row['product_id'] . " || "; 
                                        echo "name: " . $row['product_name']." || "; 
                                        echo "img file name: " . $row['product_img']." || ";  
                                        echo "description: " . $row['product_description'] . " || ";
                                        echo "category: " . $row['category_id'] . "</br>"; 
                                    }
                                    mysqli_free_result($res); 
                                } else {
                                    echo "Cannot query.</br>";
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="col-3" scope="row">Add product:</th>
                        <td class="col-9">
                            <form action="dbAddProduct.php" method="post" enctype="multipart/form-data">
                                <input type="file" class="form-control-file" name="productImg" id="productImg"></br>
                                <input type="text" class="form-control" name="productName" id="productName" placeholder="Enter product name..."></br>
                                <textarea class="form-control" name="productDesc" id="productDesc" rows="3" placeholder="Enter product description...(optional)"></textarea>
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
                        <th scope="row">Set highlight products:</br>(show in home page)</th>
                        <td>
                            developing...
                        </td>
                    </tr>
                </table>

            </div>
            </div>
        </div>

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
                <table class="table table-striped table-dark">
                    <caption>Config & database information</caption>
                    <tr>
                        <th class="col-3" scope="row">Real path:</th>
                        <td class="col-9">
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
                </table>

            </div>
            </div>
        </div>

    </div>
</body>
