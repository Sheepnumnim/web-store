<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    print_r($_POST);
    echo "</br>";
    print_r($_FILES);

    $sql = "SELECT category_id, category_name FROM categories";
    $cNameArray = array();
    $count = 0;
    if ($res = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_array($res)) {
            $cNameArray[$count]['category_name'] = $row['category_name'];
            $cNameArray[$count]['category_id'] = $row['category_id'];
            $count++;
        }
        mysqli_free_result($res);
    } else {
        echo "Cannot query.</br>";
    }
    echo "</br>";
    print_r($cNameArray);
    echo "</br>";
    echo "</br>";
    foreach($cNameArray as $data){
        // print_r($data);echo "</br>";
        echo $data['category_id'] . " " . $data['category_name'] . "</br>";
    }

    $sql = "UPDATE products SET ";

    $file_name = basename($_FILES["productImg"]["name"]);
    $target_dir = "uploads/products/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($_FILES["productImg"]["tmp_name"] != NULL) {
        $check = getimagesize($_FILES["productImg"]["tmp_name"]);
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
        if (move_uploaded_file($_FILES["productImg"]["tmp_name"], $target_dir . $file_name)) {
            echo "The file ". basename($_FILES["productImg"]["name"]) . " has been uploaded.</br>";
            $sql = $sql." product_img='".basename($_FILES['productImg']['name'])."', ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
    if($_POST['productName'] != NULL && $_POST['productName'] != "NO IMAGE TITLE") {
        $sql = $sql." product_name='$_POST[productName]', ";
    } 
    foreach($cNameArray as $data){
        if($data['category_name'] == $_POST['categoryName']) {
            $sql = $sql." category_id=$data[category_id], ";
        }
    }
    $sql = $sql." product_fav=$_POST[hiddenfav]";
    $sql = $sql." WHERE product_id=$_POST[hiddenid]";
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
