<?php include('dbconnect.php');?>
<?php
// show all data in $_POST
/*
print_r($_POST);
foreach ($_POST as $key => $value) {
    if($value == NULL) {
        echo $key . " : NULL</br>";
    } else {
        echo $key . " : " . $value . "</br>";
    }
}
*/

if(isset($_POST["submit"])) {
    // check data and set default
    
    foreach ($_POST as $key => $value) {
        if($value == NULL) {
            switch($key) {
                case "productName" :
                    $_POST[$key] = "NO IMAGE TITLE";
                break;
                case "productDesc" :
                    $_POST[$key] = "NO IMAGE DESCRIPTION";
                break;
                case "productCategory" :
                    $_POST[$key] = 1;
                break;
            }
        }
    }

    $file_name = basename($_FILES["productImg"]["name"]);
    if($file_name == NULL) {
        $file_name = "no-photo.png";
    }
    foreach ($_POST as $key => $value) {
        if($value == NULL) {
            echo $key . " : NULL</br>";
        } else {
            echo $key . " : " . $value . "</br>";
        }
    }
    echo $file_name . "</br>";

    $target_dir = "uploads/products/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if($_FILES["productImg"]["tmp_name"] != NULL) {
        $check = getimagesize($_FILES["productImg"]["tmp_name"]);
        if($check !== false) {
            echo $_FILES["productImg"]["tmp_name"] . "is an image. going to upload to " . $target_dir . ". </br>";
            $uploadOk = 1;
        } else {
            echo "Sorry, your file is not an image.</br>";
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 1;
    }
    
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.</br>";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["productImg"]["tmp_name"], $target_file) ) {
            echo "The file ". basename($_FILES["productImg"]["name"]) . " has been uploaded.</br>";
        } else {
            echo "Sorry, there was an error uploading your file.</br>";
        }
    
        $sql = "INSERT INTO products 
        SET product_name = '$_POST[productName]',
        product_img = '$file_name',
        product_description = '$_POST[productDesc]',
        category_id = '$_POST[productCategory]'";
        if (mysqli_query($conn, $sql, MYSQLI_STORE_RESULT)) {
            echo "Successfull query.</br>";
        } else {
            echo "Cannot query.</br>";
        }
    }

}

// close database connection
mysqli_close($conn);

?>

<a href="admin.php">back to admin</a>
