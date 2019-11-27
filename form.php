<!DOCTYPE html>
<html>
<body>

<form action="dbconnect.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<form action="dbAddCategory.php" method="post">
    Add category details.
    <input type="text" name="categoryName" id="categoryName" placeholder="categoryName">
    <input type="text" name="categoryImg" id="categoryImg" placeholder="categoryImg">
</form>

</body>