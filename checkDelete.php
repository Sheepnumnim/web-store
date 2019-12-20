<?php include('dbconnect.php');?>
<?php

if(isset($_POST["id"])) {
    $req_id = $_POST['id'];
    // echo "data: ".$req_id;
    // exit();

    $sql_select = "select count(product_id) as count from products where category_id=".$req_id;
    if($res = mysqli_query($conn, $sql_select)) {
        while($row = mysqli_fetch_array($res)) {
            $count = $row['count'];
            if($count > 0) {
                echo "This category is related to some product.\nIf you delete this, you will also delete all products in this category.\n\nAre you sure?";
            } else {
                echo "Delete?";
            }
        }
        mysqli_free_result($res);
        exit();
    } else {
        echo "query fail.";
        exit();
    }
} else {
    echo "sorry, error.";
    exit();
}

// close database connection
mysqli_close($conn);
exit();
?>
