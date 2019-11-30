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

/*
$arr1 = array(1, 2);
$arr2 = array(1, 3, 5, 8);

$containsSearch = count(array_intersect($arr1, $arr2)) == count($arr1);
echo $containsSearch . ".</br>";
if(count(array_intersect($arr1, $arr2)) == count($arr1))
    echo "isin.</br>";
else{
    echo "is not in.</br>";
}
*/

// fields from query
$num_fields = 0;
$num_rows = 0; 

$sql = "SELECT * FROM categories";
if ($res = mysqli_query($conn, $sql)) {
    print_r($res);
    echo "</br>";
    $count = 0;
    while ($row = mysqli_fetch_array($res)) { 
        $rows[$count] = $row;
        print_r($row);
        echo "</br>";
        $count++;
        // echo "id: " . $row['category_id'] . " || "; 
        // echo "name: " . $row['category_name']." || "; 
        // echo "img file name: " . $row['category_img']." || ";  
        // echo "position: " . $row['category_pos']."</br>";
    }
    $ares = (array) $res;
    $num_fields = mysqli_num_fields($res);
    $num_rows = mysqli_num_rows($res);
    mysqli_free_result($res); 
} else {
    echo "Cannot query.</br>";
}
echo "</br>";
echo "</br>";
print_r($rows[0][2]);
echo "</br>";
print_r($rows[1]);
echo "</br>";
echo "</br>";
// foreach ($rows as $key => $value) {
//     echo $key . " >> " . $value . "</br>";
// }

$current_pos = 0;
$all_pos = array(NULL);

foreach($rows as $key => $value) {
    $all_pos[$key] = $rows[$key]['category_pos'];
}

echo "min: " . min($all_pos) . " || max: " . max($all_pos) . "</br>";

foreach($rows as $key => $value) {
    $rows[$key]['category_pos'] = $rows[$key]['category_pos'] - min($all_pos);
}
foreach($rows as $row) {
    // echo "id[".$row['category_id']."] : pos = ".$row['category_pos']."</br>";
    print_r($row);
    echo "</br>";
}
echo "</br>";
echo "</br>";
$all_pos = array(NULL);
foreach($rows as $key => $value) {
    // 0 or duplicate value
    if($rows[$key]['category_pos'] == 0 || in_array($rows[$key]['category_pos'], $all_pos)) {
        $r = range(1, $current_pos);
        if(count(array_intersect($r, $all_pos)) == count($r)){
            $current_pos++;
            for($i=1; $i < count($all_pos); $i++) {
                if(in_array($current_pos, $all_pos)){
                    $current_pos++; // increase current pos untill found empty pos
                }
            }
            $all_pos[$key] = $current_pos;
            $rows[$key]['category_pos'] = $current_pos;
        } else {
            for($i=1; $i!=0; ) {
                // decrease current pos untill found empty pos
                if(in_array($current_pos, $all_pos)){
                    $current_pos--;
                } else {
                    $all_pos[$key] = $current_pos;
                    $rows[$key]['category_pos'] = $current_pos;
                    $i = 0;
                }
            }
        }
    // over value
    } elseif($rows[$key]['category_pos'] > $num_rows) {
        $current_pos = $num_rows;
        for($i=1; $i!=0; ) {
            // decrease current pos untill found empty pos
            if(in_array($current_pos, $all_pos)){
                $current_pos--;
            } else {
                $all_pos[$key] = $current_pos;
                $rows[$key]['category_pos'] = $current_pos;
                $i = 0;
            }
        }
    // normal new value
    } else {
        $current_pos = $rows[$key]['category_pos'];
        $all_pos[$key] = $current_pos;

        // $r = range(1, $rows[$key]['category_pos']-1);
        // // add to back
        // if(count(array_intersect($r, $all_pos)) == count($r)){
        //     $current_pos++;
        //     $all_pos[$key] = $current_pos;
        //     $rows[$key]['category_pos'] = $current_pos;
        // // add to empty pos
        // } else {
        //     $highest = $rows[$key]['category_pos'];
        //     for($i=1; $i < count($all_pos); $i++) {
        //         if(!in_array($highest ,$all_pos)) {
        //             $current_pos = $highest-1;
        //             break;
        //         } else {
        //             $highest++;
        //         }
        //     }
        // }
    }
}
foreach($rows as $row) {
    $sql = "UPDATE categories SET category_pos = " . $row['category_pos'] . " WHERE category_id = " . $row['category_id'];
    if ($res = mysqli_query($conn, $sql)) {
        echo "Query success.</br>";
    } else {
        echo "Cannot query.</br>";
    }
}

// close database connection
mysqli_close($conn);

?>

<a href="admin.php">back to admin</a>
