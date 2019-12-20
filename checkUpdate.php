<?php include('dbconnect.php');?>
<?php

if(isset($_POST["pos"])) {
    $req_pos = $_POST['pos'];
    // echo "data: ".$req_pos;
    // exit();

    // if($req_pos == 0) {
    //     echo "This position is 0 or less than 1.\nThis category will be appended to the last position.";
    //     exit();
    // }
    // else {
        $sql_select = "select count(category_id) as count from categories";
        if($res = mysqli_query($conn, $sql_select)) {
            while($row = mysqli_fetch_array($res)) {
                $count = $row['count'];
                if($count < $req_pos) {
                    echo "Position cannot be more than amount of category.\nPlease change.";
                } else {
                    echo "Save?";
                }
            }
            mysqli_free_result($res);
            exit();
        } else {
            echo "query fail.";
            exit();
        }
    // }
} else {
    echo "sorry, error.";
    exit();
}

// close database connection
mysqli_close($conn);
exit();
?>
