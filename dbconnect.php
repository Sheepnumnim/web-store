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

while($current_pos < $num_rows) {
    foreach($rows as $key => $value) {
        // print_r($value);
        if($rows[$key]['category_pos'] == 0 || in_array($rows[$key]['category_pos'], $all_pos)) {
            $current_pos++;
            $rows[$key]['category_pos'] = $current_pos;
            $all_pos[$key] = $current_pos;
        } else {
            $all_pos[$key] = $rows[$key]['category_pos'];
            $current_pos = max($all_pos);
        }
        echo "cur pos: ".$current_pos."<br/>";
        // $rows[$key]['category_pos'] = 1;
        // echo "id[".$value['category_id']."] : pos = ".$value['category_pos']."</br>";
        // echo "</br>";
    }
    foreach($rows as $row) {
        // echo "id[".$row['category_id']."] : pos = ".$row['category_pos']."</br>";
        print_r($row);
        echo "</br>";
    }
    break;
}

// close database connection
mysqli_close($conn);

?>

<a href="admin.php">back to admin</a>
