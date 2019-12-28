<?php
    if (isset($_POST["submit"])){
        print_r($_POST);

        $dbhost = 'localhost:3306';
        $dbuser = 'root';
        $dbpass = '';
        $dbname = 'mydb';
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if(! $conn ) {
            echo "could not connect";
            // die('Could not connect: ' . mysqli_error());
        }

        $sql = "SELECT * FROM accounts WHERE 
        user_name = '$_POST[username]' AND
        user_password = '$_POST[password]'";
        echo "</br>".$sql."</br>";
        if($res = mysqli_query($conn, $sql)) {
            $row = mysqli_fetch_array($res);
            // echo 'row: '.$row[0].'||';
            // echo 'row: '.gettype($row[0]).'||';
            if($row[0] == '1'){
                // echo 'in!!!';
                setcookie("type", "user", time() + 3600);
                header('Location: '.'admin.php');
                // exit();
            }
            else{
                echo 'out!!!';
                // header('Location: '.'login.php');
                // exit();
            }
        } else {
            // header('Location: '.'login.php');
            echo 'no';
            // exit();
        }
        mysqli_close($conn);
    } else {
        print_r($_POST);
        echo "sorry.";
        // exit();
    }
?>