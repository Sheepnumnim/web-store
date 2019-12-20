<?php include('dbconnect.php');?>
<?php

if(isset($_POST["submit"])) {
    print_r($_POST);
    echo "</br>";
    print_r($_FILES);
    echo "</br></br>";

    $req_pos = $_POST['categoryPos'];
    $ccount = 0;

    $sql_count = "DELETE FROM products WHERE category_id=".$_POST['hiddenid'];
    if(mysqli_query($conn, $sql_count)) {
        echo "query success1.";
        echo "</br>";
    } else {
        echo "query fail.";
    }

    $sql_delete = "DELETE FROM categories WHERE category_id=".$_POST['hiddenid'];
    if(mysqli_query($conn, $sql_delete)) {
        echo "query success2.";
        echo "</br>";
    } else {
        echo "query fail.";
    }

    $sql_select = "SELECT category_id, category_pos FROM categories";
    $sql_update = [];
    $count = 0;
    if($res = mysqli_query($conn, $sql_select)) {
        echo "query success3.";
        echo "</br>";
        while ($row = mysqli_fetch_array($res)) {
            print_r($row);
            echo "</br>";
            if($row['category_pos'] > $req_pos) {
                $newpos = $row['category_pos'] - 1;
                $sql_update[$count] = "UPDATE categories SET category_pos=".$newpos." WHERE category_id=".$row['category_id'];
                echo $sql_update[$count]."</br>";
                $count++;
            } else {
                echo "nothing to change.</br>";
            }
        }
        mysqli_free_result($res);
    } else {
        echo "query fail.";
    }

    echo "</br>";
    foreach( $sql_update as $sql){
        echo $sql."</br>";
        if(mysqli_query($conn, $sql)) {
            echo "query success4.";
        }
        else {
            echo "query fail.";
        }
    }
    // print_r($sql_update);
}

// close database connection
mysqli_close($conn);

?>

</br>
<p id="output"></p>
<a href="admin.php">back to admin</a>
