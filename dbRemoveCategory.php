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

if(isset($_POST["submit"])) {
    if(!empty($_POST['ckeck_cat_id'])) {
        foreach($_POST['ckeck_cat_id'] as $check) {
                echo $check; //echoes the value set in the HTML form for each checked checkbox.
                             //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                             //in your case, it would echo whatever $row['Report ID'] is equivalent to.
        }
    }
}
// arrange pos
// fetch rows
$num_fields = 0;
$num_rows = 0; 
$sql = "SELECT * FROM categories";
if ($res = mysqli_query($conn, $sql)) {
    $count = 0;
    while ($row = mysqli_fetch_array($res)) { 
        $rows[$count] = $row;
        $count++;
    }
    $num_fields = mysqli_num_fields($res);
    $num_rows = mysqli_num_rows($res);
    mysqli_free_result($res); 
} else {
    echo "Cannot query.</br>";
}
echo "</br>";

// normalize all rows-pos
$current_pos = 0;
$all_pos = array(NULL);
foreach($rows as $key => $value) {
    $all_pos[$key] = $rows[$key]['category_pos'];
}
foreach($rows as $key => $value) {
    $rows[$key]['category_pos'] = $rows[$key]['category_pos'] - min($all_pos);
}

// arrange rows-pos
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
