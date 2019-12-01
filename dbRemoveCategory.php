<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    if(!empty($_POST['ckeck_cat_id'])) {
        $sql = "DELETE FROM categories WHERE category_id IN (";
        foreach($_POST['ckeck_cat_id'] as $check) {
             $sql = $sql . $check . ", ";
        }
        $sql = rtrim(trim($sql), ',');
        $sql = $sql . ")";
        echo $sql."</br>";

        if (mysqli_query($conn, $sql)) {
            echo "Successfull query.</br>";
        } else {
            echo "Cannot query1.".mysqli_error($conn)."</br>";
            // echo '<script language="javascript">';
            // echo 'var isconfirm = confirm("Warning! '.'These data are related to some data from products. \nDo you really want to remove it?'.'")';
            // echo '</script>';
            echo "<button type=\"button\""
                ."onclick=\"document.getElementById('demo').innerHTML = 'Continue delete...'\">"
                ."Warning! These data are related to some data from products. </br>Do you really want to remove it?.</button>";
        }
    } else {
        echo "not checked.";
    }
}

// close database connection
mysqli_close($conn);

?>

</br>
<p id="output"></p>
<a href="admin.php">back to admin</a>
