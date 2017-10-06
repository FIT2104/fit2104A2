<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 17/09/2017
 * Time: 11:32 PM
 */
?>
<script language="JavaScript">
    function validateCategory() {
        var nameC = document.forms["form"]["name"].value;
        var descC = document.forms["form"]["desc"].value;

        if (nameC == null || nameC == "") {
            alert("Category name cannot be empty");
            return false;
        }
        if (nameC.length > 20) {
            alert("Category name shouldn't be more than 20 characters");
            return false;
        }
        if (descC.length > 100) {
            alert("Category description shouldn't be more than 100 characters");
            return false;
        }
        return true;
        }
</script>

<?php
ob_start();
include("menu.php");
?>
<html>
<head><title>Category Modification </title></head>
<body>

<?php
$strAction = $_GET["Action"];
switch ($strAction) {

//when add button from category table page was clicked
case "Add": {
    ?>
    <center><h2>Add category</h2></center>
    <form method="post" name="form" action="categoryModify.php?Action=ConfirmAdd" onsubmit="return validateCategory();">
        <table border="3" align="center">
            <tr>
                <td><b>Category name</b></td>
                <td><input type="text" size="20" name="name"></td>
            </tr>
            <tr>
                <td><b>Category Description</b></td>
                <td><input type="text" size="20" name="desc"></td>
            </tr>

        </table>
        <?php
        ?>
        <center>
            <input type="submit" value="Add category">
            <input type="button" value="Return to List " OnClick="window.location='category.php?sort='">
        </center>
    </form>
<?php

break;
}

//when confirm add from add category page was clicked
case "ConfirmAdd": {
$query = "INSERT INTO Category (category_name,category_description) VALUES ('$_POST[name]','$_POST[desc]')";
$result = $conn->query($query);
if ($result){
?>
    <script language="JavaScript">
        alert("New Category successfully added to database");
        window.location = 'category.php?sort=';
    </script>
<?php
} else {
?>
    <script language="JavaScript">
        alert("Error adding record. Please contact System Administrator");
        window.location = 'categoryModify.php?Action=Add';
    </script>
<?php
}
$result->free_result();
$conn->close();
break;
}

//when update button from category table page was clicked
case "Update": {
$query = "SELECT * FROM Category WHERE category_id=" . $_GET["category_id"];
$result = $conn->query($query) or die('Error querying database');
$row = $result->fetch_assoc();
?>
    <form method="post" name="form" action="categoryModify.php?category_id=<?php echo $_GET["category_id"]; ?>&Action=ConfirmUpdate"  onsubmit="return validateCategory();">
        <center><h3>Category Details</h3></center>
        <br>
        <table border="3" align="center" cellpadding="3">
            <tr>
                <td><b>Category Name</b></td>
                <td><input type="text" name="name" value="<?php echo $row["category_name"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Category Description</b></td>
                <td><input type="text" name="desc" value="<?php echo $row["category_description"]; ?>"></td>
            </tr>
        </table>

        <center>
        <input type="submit" value="Update category"">
        <input type="button" value="Return to List" OnClick="window.location='category.php?sort='">
        </center>
    </form>

<?php
$result->free_result();
break;
}
//when confirm update button from update category page was clicked
case "ConfirmUpdate": {
$name = $_POST['name'];
$desc = $_POST['desc'];
$id = $_GET['category_id'];
$query = "UPDATE Category SET category_name='$name',category_description='$desc'WHERE category_id='$id'";
$result = $conn->query($query) or die('Error querying database.');

if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been updated successfully");
        window.location = 'category.php?sort=';
    </script>
<?php
}else
?>
    <script language="JavaScript">
        alert("Error updating record. Please contact System Administrator");
        window.location = 'categoryModify.php?Action=Update';
    </script>
<?php
$result->free_result();
$conn->close();
break;

}

//when delete button from category table page was clicked
case "Delete": {
$query = "SELECT * FROM Category WHERE category_id=" . $_GET["category_id"];
$result = $conn->query($query) or die('Error querying database');
$row = $result->fetch_assoc();
?>
    <center>
        <h3> Are you sure you want to delete this record?</h3>
        <table border="3" cellpadding="3">
            <tr>
                <td><b>Category ID</b></td>
                <td><?php echo $row["category_id"]; ?></td>
            </tr>
            <tr>
                <td><b>Category Name</b></td>
                <td><?php echo $row["category_name"]; ?></td>
            </tr>
        </table>
        <table align="center">
            <tr>
                <td><input type="submit" value="Confirm"
                           OnClick="window.location='categoryModify.php?category_id=<?php echo $_GET["category_id"]; ?>&Action=ConfirmDelete';">
                </td>
                <td><input type="button" value="Cancel" OnClick="window.location='category.php?sort='"></td>
            </tr>
        </table>
    </center>
<?php
$result->free_result();
break;
}

//when confirm delete button from delete category page was clicked
case "ConfirmDelete":{
$query = "SELECT * FROM ProductCategory WHERE category_id=". $_GET["category_id"];
$result = $conn->query($query) or die('Error querying database.');
if ($result->num_rows == 0){
$query1 = "DELETE FROM Category WHERE category_id =" . $_GET["category_id"];
$result1 = $conn->query($query1) or die('Error querying database.');
if ($result1) {
?>
    <script language="JavaScript">
        alert("The selected record had been deleted successfully");
        window.location = 'category.php?sort=';
    </script>
<?php
}else {
?>
    <script language="JavaScript">
        alert("Error deleting record. Please contact system administrator.");
        window.location = 'category.php?sort=';
    </script>

    <?php

}
    $result1->free_result();
} else {
    ?>
    <script language="JavaScript">
        alert("Error deleting record. There is one or more products had assigned this category, please unbind the product before deleting this category.");
        window.location = 'category.php?sort=';
    </script>
<?php
}
$result->free_result();
$conn->close();
    break;
}
}
?>
<table>
    <td align="center">
        <div class="round-button">
            <a href="sourceCode.php?destination=categoryModify.php" target="_blank">
                <img name="myImg" src="images/productcategory.png" alt="Product Category Source Code"/>
            </a>
        </div>
    </td>
</table>
</body>
</html>
