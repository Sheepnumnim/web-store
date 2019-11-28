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

# things from admin
echo $_POST["categoryName"] . "</br>";
echo $_POST["categoryImg"] . "</br>";

$sql = "INSERT INTO categories 
SET category_name = '$_POST[categoryName]',
category_img = '$_POST[categoryImg]'";
if (mysqli_query($conn, $sql, MYSQLI_STORE_RESULT)) {
    echo "Successfull query.</br>";
} else {
    echo "Cannot query.</br>";
}

// close database connection
mysqli_close($conn);

?>

<a href="admin.php">back to admin</a>
