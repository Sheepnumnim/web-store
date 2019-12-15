<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    $sql = "DELETE FROM categories WHERE category_id=".$_POST['hiddenid'];
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
