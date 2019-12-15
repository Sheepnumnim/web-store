<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    print_r($_POST);
    echo "</br>";
    print_r($_FILES);
    echo "</br>";

    $sql = "UPDATE categories SET ";

    $file_name = basename($_FILES["categoryImg"]["name"]);
    $target_dir = "uploads/categories/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($_FILES["categoryImg"]["tmp_name"] != NULL) {
        $check = getimagesize($_FILES["categoryImg"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.</br>";
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.</br>";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["categoryImg"]["tmp_name"], $target_dir . $file_name)) {
            echo "The file ". basename($_FILES["categoryImg"]["name"]) . " has been uploaded.</br>";
            $sql = $sql." category_img='".basename($_FILES['categoryImg']['name'])."', ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
    if($_POST['categoryGroup'] == "new group") {
        $sql = $sql." category_group='$_POST[newcGroup]', ";
    } else {
        $sql = $sql." category_group='$_POST[categoryGroup]', ";
    }
    $sql = $sql." category_name='$_POST[categoryName]' ";
    $sql = $sql." WHERE category_id=$_POST[hiddenid]";
    echo "</br>".$sql;
    if($res = mysqli_query($conn, $sql)) {
        echo "query success.";
    } else {
        echo "query fail.";
    }
}

// close database connection
mysqli_close($conn);

?>

</br>
<p id="output"></p>
<a href="admin.php">back to admin</a>
