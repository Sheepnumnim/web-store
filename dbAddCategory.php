<?php include('dbconnect.php');?>
<?php

// add image to server and query data to database
if(isset($_POST["submit"])) {
    print_r($_POST);
    echo "</br>";
    print_r($_FILES);
    echo "</br></br>";

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
            echo $key . " : " . $value;
            echo "</br>";
        }
    }
    echo $file_name . "</br>";
    echo "</br>";

    $amount = 0;
    $sql = "select count(category_id) as amount from categories";
    if ($res = mysqli_query($conn, $sql)) {
        echo "Successfull query.</br>";
        $row = mysqli_fetch_array($res);
        echo "amount: ".$row['amount']."</br>";
        $amount = $row['amount'];
        mysqli_free_result($res);
    } else {
        echo "Cannot query.</br>";
    }

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
    
    $sql = "INSERT INTO categories SET ";

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.</br>";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["categoryImg"]["tmp_name"], $target_dir . $file_name)) {
            echo "The file ". basename($_FILES["categoryImg"]["name"]) . " has been uploaded.</br>";
            $sql = $sql." category_img = '$file_name', ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        if ($_POST['categoryGroup'] == "new group") {
            $sql = $sql." category_group = '$_POST[newcGroup]', ";
        } else {
            $sql = $sql." category_group = '$_POST[categoryGroup]', ";
        }
        $pos = $amount+1;
        $sql = $sql." category_pos = '$pos', ";
        $sql = $sql." category_name = '$_POST[categoryName]' ";
        echo "</br></br>".$sql;
        if (mysqli_query($conn, $sql, MYSQLI_STORE_RESULT)) {
            echo "Successfull query.</br>";
        } else {
            echo "Cannot query.</br>";
        }
    }
}

// // arrange pos
// // fetch rows
// $num_fields = 0;
// $num_rows = 0; 
// $sql = "SELECT * FROM categories";
// if ($res = mysqli_query($conn, $sql)) {
//     $count = 0;
//     while ($row = mysqli_fetch_array($res)) { 
//         $rows[$count] = $row;
//         $count++;
//     }
//     $num_fields = mysqli_num_fields($res);
//     $num_rows = mysqli_num_rows($res);
//     mysqli_free_result($res); 
// } else {
//     echo "Cannot query2.</br>";
// }
// echo "</br>";

// // normalize all rows-pos
// $current_pos = 0;
// $all_pos = array(NULL);
// foreach($rows as $key => $value) {
//     $all_pos[$key] = $rows[$key]['category_pos'];
// }
// foreach($rows as $key => $value) {
//     $rows[$key]['category_pos'] = $rows[$key]['category_pos'] - min($all_pos);
// }

// arrange rows-pos
// $all_pos = array(NULL);
// foreach($rows as $key => $value) {
//     // 0 or duplicate value
//     if($rows[$key]['category_pos'] == 0 || in_array($rows[$key]['category_pos'], $all_pos)) {
//         $r = range(1, $current_pos);
//         if(count(array_intersect($r, $all_pos)) == count($r)){
//             $current_pos++;
//             for($i=1; $i < count($all_pos); $i++) {
//                 if(in_array($current_pos, $all_pos)){
//                     $current_pos++; // increase current pos untill found empty pos
//                 }
//             }
//             $all_pos[$key] = $current_pos;
//             $rows[$key]['category_pos'] = $current_pos;
//         } else {
//             for($i=1; $i!=0; ) {
//                 // decrease current pos untill found empty pos
//                 if(in_array($current_pos, $all_pos)){
//                     $current_pos--;
//                 } else {
//                     $all_pos[$key] = $current_pos;
//                     $rows[$key]['category_pos'] = $current_pos;
//                     $i = 0;
//                 }
//             }
//         }
//     // over value
//     } elseif($rows[$key]['category_pos'] > $num_rows) {
//         $current_pos = $num_rows;
//         for($i=1; $i!=0; ) {
//             // decrease current pos untill found empty pos
//             if(in_array($current_pos, $all_pos)){
//                 $current_pos--;
//             } else {
//                 $all_pos[$key] = $current_pos;
//                 $rows[$key]['category_pos'] = $current_pos;
//                 $i = 0;
//             }
//         }
//     // normal new value
//     } else {
//         $current_pos = $rows[$key]['category_pos'];
//         $all_pos[$key] = $current_pos;
//     }
// }
// foreach($rows as $row) {
//     $sql = "UPDATE categories SET category_pos = " . $row['category_pos'] . " WHERE category_id = " . $row['category_id'];
//     if ($res = mysqli_query($conn, $sql)) {
//         echo "Query success.</br>";
//     } else {
//         echo "Cannot query3.</br>";
//     }
// }

// close database connection
mysqli_close($conn);

?>

<a href="admin.php">back to admin</a>
