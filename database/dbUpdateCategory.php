<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    print_r($_POST);
    echo "</br>";
    print_r($_FILES);
    echo "</br></br>";

    $pos = $_POST['categoryPos'];
    $id = $_POST['hiddenid'];
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
    
    $categoryVar = 'categoryGroup_show'.$_POST['hiddenid'];
    $categoryInputVar = 'categoryGroupInput'.$_POST['hiddenid'];
    if($_POST[$categoryVar] == "new group") {
        $sql = $sql." category_group='$_POST[$categoryInputVar]', ";
    } else {
        $sql = $sql." category_group='$_POST[$categoryVar]', ";
    }

    $sql_select = "select category_id, category_pos from categories";
    $data = [];
    $cpos = 0;
    if($res = mysqli_query($conn, $sql_select)) {
        echo "<br>";
        echo "query success.<br>";
        while($row = mysqli_fetch_array($res)) {
            $data[] = $row;
            if($row['category_id'] == $id) {
                $cpos = $row['category_pos'];
            }
        }
        print_r($data);
        echo "<br>";
    } else {
        echo "query fail.";
    }

    $sql = $sql." category_pos='$_POST[categoryPos]', ";
    $sql = $sql." category_name='$_POST[categoryName]' ";
    $sql = $sql." WHERE category_id=$_POST[hiddenid]";
    echo "</br>".$sql;
    if(mysqli_query($conn, $sql)) {
        echo "query success.";
    } else {
        echo "query fail.";
    }

    $sql_update = [];
    $count = 0;
    if($pos > $cpos) {
        foreach($data as $dt) {
            $value = $dt['category_pos'];
            $min = $cpos+1;
            $max = $pos;
            if(($min <= $value) && ($value <= $max)) {
                $newpos = $value-1;
                $sql_update[] = "update categories set category_pos=".$newpos." where category_id=".$dt['category_id'];
            }
            $count++;
        }
    }
    else if($pos < $cpos) {
        foreach($data as $dt) {
            $value = $dt['category_pos'];
            $min = $pos;
            $max = $cpos-1;
            if(($min <= $value) && ($value <= $max)) {
                $newpos = $value+1;
                $sql_update[] = "update categories set category_pos=".$newpos." where category_id=".$dt['category_id'];
            }
            $count++;
        }
    }
    else {
        echo "<br>nothing change";
    }
    echo "<br>";
    print_r($sql_update);
    // echo sizeof($sql_update);
    foreach($sql_update as $s) {
        if(mysqli_query($conn, $s)) {
            echo "query success.";
        } else {
            echo "query fail.";
        }
    }
}

// close database connection
mysqli_close($conn);

?>

</br>
<p id="output"></p>
<a href="admin.php">back to admin</a>
