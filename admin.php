<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iconperfect';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
if(! $conn ) {
    die('Could not connect: ' . mysqli_error());
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
        }
    </script>
</head>

<body class="container bg-dark">
    <h1 class="text-light">Admin</h1>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>

    <!-- Categories -->
    <table class="table table-striped table-dark">
        <caption>Categories</caption>
        <tr>
            <th class="col-3" scope="row">Add category:</th>
            <td class="col-9">
                <form action="dbAddCategory.php" method="post" enctype="multipart/form-data" onsubmit="return validate();">
                    <input type="file" class="form-control-file" name="categoryImg" id="categoryImg"></br>
                    <input type="text" class="form-control" name="categoryName" id="categoryName" placeholder="Enter category name..."></br>
                    <div class="invalid-feedback">
                        Please enter category name.
                    </div>
                    </br><input type="submit" class="btn btn-outline-light" value="Add category" name="submit">
                </form>
            </td>
        </tr>
        <tr>
            <th scope="row">All categories:</th>
            <td>
                <?php
                    $sql = "SELECT * FROM categories";
                    if ($res = mysqli_query($conn, $sql)) {
                        while ($row = mysqli_fetch_array($res)) { 
                            echo "id: " . $row['category_id'] . " || "; 
                            echo "name: " . $row['category_name']." || "; 
                            echo "img file name: " . $row['category_img']." || ";  
                            echo "position: " . $row['category_pos']."</br>";
                        }
                        mysqli_free_result($res); 
                    } else {
                        echo "Cannot query.</br>";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Set categories arranging: </br>(show in products page)</th>
            <td>
                developing...
            </td>
        </tr>
    </table>
    
    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>

    <!-- Products -->
    <table class="table table-striped table-dark">
        <caption>Products</caption>
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
                                echo $row['category_name']; 
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
            <th scope="row">Set highlight products:</th>
            <td>
                developing...
            </td>
        </tr>
    </table>

    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>

    <!-- Config & database information -->
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

    <p>&nbsp;</p>
    <hr style="border:2px solid white">
    <p>&nbsp;</p>
</body>

<?php
    mysqli_close($conn);
?>
