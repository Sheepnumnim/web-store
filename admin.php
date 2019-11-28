<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body class="container">
    <h1>Admin</h1>
    <table class="table table-striped">
        <tr>
            <th scope="row">Add category:</th>
            <td>
                <form action="dbAddCategory.php" method="post">
                    <input type="text" name="categoryName" id="categoryName" placeholder="categoryName"></br>
                    <input type="file" name="categoryImg" id="fileToUpload"></br>
                    </br><input type="submit" class="btn btn-outline-dark" value="Add category" name="submit">
                </form>
            </td>
        </tr>
        <tr>
            <th scope="row">Add product:</th>
            <td>
                <form action="dbconnect.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload"></br>
                    add to category
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Default radio
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Second default radio
                        </label>
                        </div>
                        <div class="form-check disabled">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                        <label class="form-check-label" for="exampleRadios3">
                            Disabled radio
                        </label>
                    </div>
                    </br><input type="submit" class="btn btn-outline-dark" value="Add product" name="submit">
                </form>
            </td>
        </tr>
        <tr>
            <th scope="row">Set categories arranging:</th>
            <td>
                developing...
            </td>
        </tr>
        <tr>
            <th scope="row">Set highlight products:</th>
            <td>
                developing...
            </td>
        </tr>
        <tr>
            <th scope="row">Real path:</th>
            <td>
                <?php
                    $realpath = realpath(__FILE__);
                    echo $realpath;
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Dir name:</th>
            <td>
                <?php
                    $path = dirname($realpath);
                    $path = str_replace("\\", "/", $path) . "/uploads";
                    echo $path;
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">File in /uploads:</th>
            <td>
                <?php
                    $files = scandir($path);
                    print_r($files);
                ?>
            </td>
        </tr>
    </table>
</body>