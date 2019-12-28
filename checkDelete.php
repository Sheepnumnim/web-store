<?php include('dbconnect.php');?>
<?php

if(isset($_POST["id"])) {
    $req_id = $_POST['id'];
    // echo "data: ".$req_id;
    // exit();
    $sql_select = "select category_name from categories where category_id=".$req_id;
    if($res = mysqli_query($conn, $sql_select)) {
        $row = mysqli_fetch_array($res);
        if($row['category_name'] == "Others") {
            echo "3";
            exit();
        }
    } else {
        echo "query fail.";
        exit();
    }

    $sql_select = "select count(product_id) as count from products where category_id=".$req_id;
    if($res = mysqli_query($conn, $sql_select)) {
        while($row = mysqli_fetch_array($res)) {
            $count = $row['count'];
            if($count > 0) {
                echo "2";
            } else {
                echo "1";
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
