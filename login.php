<?php include('get_style.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery Get Selected Radio Button Value</title>
<link rel="stylesheet" href="css/login.css" type="text/css">
</head> 
<body class="login-body">
    <div class="login-page">
    <div class="form">
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="register-form">
            <fieldset class="form-group">
                <legend class="col-form-label">New user details</legend>
                <input type="text" id="" name="username" maxlength="12" placeholder="new username" require/>
                <input type="password" name="password" maxlength="20" placeholder="new password" require/>
            </fieldset>
            <fieldset>
                <legend class="col-form-label">Persuader user details</legend>
                <input type="text" name="username" maxlength="12" placeholder="name" require/>
                <input type="password" name="password" maxlength="20" placeholder="password" require/>
            </fieldset>
            <button type="submit" name="submit" value="submit">create</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
        <form action="dblogin.php" method="post" class="login-form">
            <fieldset class="form-group">
                <legend class="col-form-label">Login</legend>
                <input type="text" name="username" maxlength="12" placeholder="username" require/>
                <input type="password" name="password" maxlength="20" placeholder="password" require/>
            </fieldset>
            <button type="submit" name="submit" value="login">login</button>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
        </form>
    </div>
    </div>
    <?php include('get_script.php');?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$('.message a').click(function(){
    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});</script>
</body>
</html>