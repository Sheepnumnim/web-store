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

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".</br>";
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.</br>";
            $uploadOk = 0;
        } else {
            $uploadOk = 1;
        } 
    } else {
        echo "File is not an image.</br>";
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.</br>";
} else { // if everything is ok, try to upload file
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename)) {
        echo "The file ". $newfilename . " has been uploaded.</br>";
        // $sql = "insert into product values ('" + $newfilename + "', 'product name', 'description', 'Bag')";
        // if (mysqli_query($conn, $sql)) {
        //     echo "Successfull query.</br>";
        // } else {
        //     echo "Cannot query.</br>";
        // }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// close database connection
mysqli_close($conn);

?>
