<?php

// connect to database
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iconperfect';

// $dbhost = 'sql308.epizy.com';
// $dbuser = 'epiz_24853426';
// $dbpass = 'rjKkr7ceK5PRB';
// $dbname = 'epiz_24853426_iconperfect';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      
if(! $conn ) {
    die('Could not connect: ' . mysqli_error());
}

?>