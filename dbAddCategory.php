<?php

// connect to database
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iconperfect';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
if(! $conn ) {
    die('Could not connect: ' . mysqli_error());
}
echo 'Connected successfully</br>';

// add image to server and query data to database
if(isset($_POST["submit"])) {
    // check data and set default
    $file_name = basename($_FILES["categoryImg"]["name"]);
    echo "file name: " . $file_name;
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

    $target_dir = "uploads/categories/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if($_FILES["categoryImg"]["tmp_name"] != NULL) {
        $check = getimagesize($_FILES["categoryImg"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.</br>";
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 1;
    }
    
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.</br>";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["categoryImg"]["tmp_name"], $target_dir . $file_name)) {
            echo "The file ". basename($_FILES["categoryImg"]["name"]) . " has been uploaded.</br>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        $sql = "INSERT INTO categories 
        SET category_name = '$_POST[categoryName]',
        category_img = '$file_name'";
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
