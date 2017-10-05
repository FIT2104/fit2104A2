<?php
session_start();
include "Authenticate.php";
ob_start();
/**
* Created by PhpStorm.
* User: Aubrey
* Date: 15/09/2017
* Time: 8:58 PM
*/
?>
<script language="JavaScript">
    function numDigits(x) {
        return Math.max(Math.floor(Math.log10(Math.abs(x))), 0) + 1;
    }

    function validateProduct() {
        var nameP = document.forms["form"]["name"].value;
        var countryO = document.forms["form"]["country"].value;
        var purchaseP = document.forms["form"]["purchase"].value;
        var saleP = document.forms["form"]["sale"].value;
        var descP = document.forms["form"]["desc"].value;

        if (nameP == null || nameP == "") {
            alert("Product name cannot be empty");
            return false;
        }
        if (nameP.length > 20) {
            alert("Product name shouldn't be more than 20 characters");
            return false;
        }
        if (countryO == null || countryO == "") {
            alert("The origin of country cannot be empty");
            return false;
        }
        if (countryO.length > 40) {
            alert("The origin of country shouldn't be more than 40 characters");
            return false;
        }
        if (purchaseP == null || purchaseP == "") {
            alert("Purchase price cannot be empty");
            return false;
        }
        else if (isNaN(purchaseP)) {
            alert("Purchase price must be numbers");
            return false;
        } else if (numDigits(purchaseP) > 10) {
            alert("Purchase price should be less than 10 digit");
            return false;
        }
        if (saleP == null || saleP == "") {
            alert("Sale price cannot be empty");
            return false;
        } else if (isNaN(saleP)) {
            alert("Sale price must be numbers");
            return false;
        } else if (numDigits(saleP) > 10) {
            alert("Sale price should be less than 10 digit");
            return false;
        }
        if (descP.length > 100) {
            alert("Product description shouldn't be more than 100 characters");
            return false;
        }
        return true;
    }
</script>
<?php
include("menu.php");
ob_start();
function fSelect($conn, $product_id, $category_id)
{
    $query = "SELECT * From ProductCategory where category_id = " . $category_id;
    $checked = "";
    $result = $conn->query(($query));
    while ($pC = $result->fetch_assoc()) {
        if ($pC["product_id"] == $product_id) {
            $checked = "checked";
            break;
        }
    }
    $result->free_result();
    return $checked;
}

?>

<html>
<head><title>Product Modification </title></head>
<body>

<?php
$strAction = $_GET["Action"];
switch ($strAction) {

//when add new product button from product table page was clicked
case "Add": {
    ?>
    <center><h2>Add product</h2></center>
    <form method="post" name="form" action="productModify.php?Action=ConfirmAdd" onsubmit="return validateProduct();">
        <table border="3" align="center">
            <tr>
                <td><b>Product name</b></td>
                <td><input type="text" size="20" name="name"></td>
            </tr>
            <tr>
                <td><b>Country of origin</b></td>
                <td><input type="text" size="20" name="country"></td>
            </tr>
            <tr>
                <td><b>Purchase price</b></td>
                <td><input type="text" size="20" name="purchase"></td>
            </tr>
            <tr>
                <td><b>Sale price</b></td>
                <td><input type="text" size="20" name="sale"></td>
            </tr>
            <tr>
                <td><b>Description</b></td>
                <td><input type="text" size="20" name="desc"></td>
            </tr>
        </table>
        <?php
        $query = "SELECT * From Category order by category_id";
        $result = $conn->query(($query));

        ?>
        <center><h3>Assign product category</h3></center>
        <table border="1" align="center" cellpadding="3">
            <tr>
                <th>Category Name</th>
                <th>Category Description</th>
            </tr>
            <?php while ($rowC = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $rowC["category_name"] ?></td>
                    <td><?php echo $rowC["category_description"] ?></td>
                    <td><input type="checkbox" name="check[]" value="<?php echo $rowC["category_id"]; ?>"</input></td>
                </tr>
            <?php } ?>
        </table>
        <center>
            <input type="submit" value="Add Product">
            <input type="button" value="Return to List " OnClick="window.location='product.php?sort=&Action=All'">
        </center>
    </form>
<?php
$result->free_result();
break;
}

//when confirm add button from add product page was clicked
case "ConfirmAdd": {
$product_name = $_POST["name"];
$query = "INSERT INTO Product (product_name,product_purchase_price,product_sale_price,product_country,product_description) VALUES('$product_name', '$_POST[purchase]','$_POST[sale]','$_POST[country]','$_POST[desc]')";
$result = $conn->query($query);
if ($result) {
if (!empty($_POST["check"])) {
    $query1 = "SELECT product_id from Product where product_name = '$product_name'";
    $result1 = $conn->query(($query1));
    $product = $result1->fetch_assoc();
    $product_id = $product["product_id"];
    foreach ($_POST["check"] as $category_id) {
        $query2 = "insert into ProductCategory value ('$product_id','$category_id')";
        $conn->query(($query2));
    }
    $result1->free_result();
}
?>
    <script language="JavaScript">
        alert("New product record successfully added to database");
        window.location = 'product.php?sort=&Action=All';
    </script>
<?php
} else {
?>
    <script language="JavaScript">
        alert("Error adding record. Please contact System Administrator.");
        window.location = productModify.php ? Action = Add';
    </script>
<?php
}
$result->free_result();
$conn->close();
break;
}

//when update button from product table page was clicked
case "Update": {
$query = "SELECT * FROM Product WHERE product_id=" . $_GET["product_id"];
$result = $conn->query($query) or die('Error querying database.');
$rowP = $result->fetch_assoc();
?>
    <form method="post" name="form"
          action="productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=ConfirmUpdate" onsubmit="return validateProduct();">
        <center><h3>Product Details</h3></center>
        <br>
        <table border="3" align="center" cellpadding="3">
            <tr>
                <td><b>Product Name</b></td>
                <td><input type="text" name="name" value="<?php echo $rowP["product_name"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Product Purchase Price</b></td>
                <td><input type="text" name="purchase" value="<?php echo $rowP["product_purchase_price"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Product Sale Price</b></td>
                <td><input type="text" name="sale" value="<?php echo $rowP["product_sale_price"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Product Country of Origin</b></td>
                <td><input type="text" name="country" value="<?php echo $rowP["product_country"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Product Description</b></td>
                <td><input type="text" name="desc" value="<?php echo $rowP["product_description"]; ?>"></td>
            </tr>
        </table>
        <br>

        <!-display assigned category table->
        <center><h3>Assign Categories</h3>
            <form method="post">
                <table border="1" cellpadding="3">
                    <tr>
                        <th>Category Name</th>
                        <th>Category Description</th>
                    </tr>
                    <?php
                    $query1 = "SELECT * FROM Category";
                    $result1 = $conn->query($query1) or die('Error querying database.');
                    while ($rowC = $result1->fetch_assoc()) {
                        ?>

                        <tr>
                            <td><?php echo $rowC["category_name"]; ?></td>
                            <td><?php echo $rowC["category_description"]; ?></td>
                            <td><input type="checkbox" name="check[]" ,
                                       value="<?php echo $rowC["category_id"] ?>" <?php echo fSelect($conn, $rowP["product_id"], $rowC["category_id"]); ?>>
                            </td>
                        </tr>
                    <?php }
                    $result1->free_result();
                    ?>
                </table>
                <br>
            </form>
            <input type="submit" value="Update product"">
            <input type="button" value="Return to list" OnClick="window.location='product.php?sort=&Action=All'">

            <!-display modify images options->
            <form method="post" enctype="multipart/form-data"
                  action="productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Upload">
                <h3>Add images</h3>
                <b>Select a file to upload:</b><br><input type="file" size="50" name="file">

                <input type="submit" value="Upload File">

            </form>

        </center>
        <?php
        ?>
    </form>

    <?php
    //display product's images
    $query2 = "select * from ProductImage where product_id =" . $_GET["product_id"];
    $result2 = $conn->query($query2);
    if ($result2->num_rows != 0) {
    ?>
    <center>
        <form method="post" enctype="multipart/form-data"
              action="productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=DeleteImage">
            <h3>Delete images</h3>

            <table border="0">
                <?php
                while ($row2= $result2->fetch_assoc()) {
                    ?>
                    <tr>
                        <td align="right" ><?php echo $row2["image_name"] ?></td>
                        <td> <?php echo "<img src=\"product_images/".$row2["image_name"]."\" width=\"320\" height=\"200\" border=0>"; ?> </td>
                        <td><input type="checkbox" name="checkImage[]" size="30"
                                   value="<?php echo $row2["image_id"] ?>"></td>
                    </tr>
                    <?php
                } ?>
                <tr>
                    <td></td>
                    <td align="right"><input type="submit" value="Delete select images"></td>
                </tr>
            </table>
        </form>
    </center>
<?php
}
$result2->free_result();
?>

<?php
$result->free_result();
break;
}

//when confirm update button from update product page was clicked
case "ConfirmUpdate": {
//update sql table
$name = $_POST['name'];
$purchase = $_POST['purchase'];
$sale = $_POST['sale'];
$country = $_POST['country'];
$desc = $_POST['desc'];
$id = $_GET['product_id'];
$query = "UPDATE Product SET product_name='$name',product_purchase_price='$purchase',product_sale_price='$sale',product_description='$desc',product_country='$country' WHERE product_id='$id'";
$result = $conn->query($query) or die('Error querying database.');

//check if record had been update successfully and return feedbacks
if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been updated successfully");
        window.location = 'product.php?sort=&Action=All';
    </script>
<?php
}else{
?>
    <script language="JavaScript">
        alert("Error updating record. Please contact System Administrator");
        window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
    </script>
<?php }


//update products' assigned categories
$product_id = $_GET["product_id"];
$query1 = "DELETE FROM ProductCategory WHERE product_id = '$product_id'"; //delete all sql assigned category records fro this product
$conn->query($query1) or die('Error querying database.');
if (!empty($_POST["check"])) {  //then reinsert all assigned category records
    foreach ($_POST["check"] as $category_id) {
        $query2 = "insert into ProductCategory value ('$product_id','$category_id')";
        $conn->query($query2) or die('Error querying database.');
    }
}

$result->free_result();
$conn->close();
break;

}

//when upload button from update product page was clicked
case "Upload": {
    //check if there is an file selected
    if ($_FILES["file"]["tmp_name"] == null) {
    ?>
        <script language="JavaScript">
            alert("No image selected");
            window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
        </script>

    <?php
    }else{
    $upfile = "product_images/" . $_FILES["file"]["name"];
    //check uploaded file type
    if ($_FILES["file"]["type"] != "image/gif" && $_FILES["file"]["type"] != "image/png" && $_FILES["file"]["type"] != "image/jpeg")
    {
    ?>
        <script language="JavaScript">
            alert("Error uploading file. You may only upload .jpg, .png or .gif files");
            window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
        </script>

    <?php
    }
    else
    {
        $query = "select * from ProductImage where product_id =" . $_GET["product_id"];
        $result = $conn->query($query);
        //check if image with the same name exist
        if ($result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["image_name"] == $_FILES["file"]["name"]){
                ?>
                    <script language="JavaScript">
                        alert("An image name with the same name exist. Please change the image name.");
                        window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                    </script>

                <?php
                break;
                }
            }
        }
        //upload image to product_images folder
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $upfile))
        {
            ?>
                <script language="JavaScript">
                    alert("Error uploading file. Unable to move file into directory");
                    window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                </script>

            <?php
        }
        else
        {
            //insert image detail to sql database
            $id = $_GET["product_id"];
            $name = $_FILES["file"]["name"];
            $query = "insert into ProductImage (image_name,product_id) values ('$name','$id')";
            if ($conn->query(($query))){
            ?>
                <script language="JavaScript">
                    alert("Successfully upload image");
                    window.location = "ProductModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                </script>
            <?php

            }else{
            ?>
                <script language="JavaScript">
                    alert("Error inserting image to database. Please contact the system administrator");
                    window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                </script>
            <?php
            }
        }
    }
}
break;
}

//when delete image button from update product page was clicked
case
"DeleteImage":{
//if there is one or more checkImage checkbox is checked
if (!empty($_POST["checkImage"])) {
    foreach ($_POST["checkImage"] as $image_id) {
    $query = "Select image_name FROM ProductImage WHERE image_id = '$image_id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    //get image name
    $nameI = "product_images/".$row["image_name"];
    //delete image
    if (!unlink($nameI)) {
        ?>
            <script language="JavaScript">
                alert("Error deleting image <?php echo $nameI?> from product images folder. Please contact the system administrator");
                window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
            </script>
        <?php

        } else {
            //remove image record from sql database
            $query = "DELETE FROM ProductImage WHERE image_id = '$image_id'";
            if (!($conn->query($query))){
            ?>
                <script language="JavaScript">
                    alert("Error deleting image from database. Please contact the system administrator  ");
                    window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                </script>
            <?php
            } else {
            ?>
                <script language="JavaScript">
                    alert("The selected files had been deleted");
                    window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
                </script>
            <?php
            }

        }
    }
} else {
    ?>
        <script language="JavaScript">
            alert("No images selected");
            window.location = "productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=Update";
        </script>
    <?php
}
$result->free_result();
break;
}

//when delete button from product table page was clicked
case "Delete": {
$query = "SELECT * FROM Product WHERE product_id=" . $_GET["product_id"];
$result = $conn->query($query) or die('Error querying database.');
$rowP = $result->fetch_assoc();
?>
    <center>
        <h3> Are you sure you want to delete this record?</h3>
        <table border="3" cellpadding="3">
            <tr>
                <td><b>Product ID</b></td>
                <td><?php echo $rowP["product_id"]; ?></td>
            </tr>
            <tr>
                <td><b>Product Name</b></td>
                <td><?php echo $rowP["product_name"]; ?></td>
            </tr>
            <tr>
                <td><b>Product Country of Origin</b></td>
                <td><?php echo $rowP["product_country"]; ?></td>
            </tr>
        </table>
        <table align="center">
            <tr>
                <td><input type="submit" value="Confirm"
                           OnClick="window.location='productModify.php?product_id=<?php echo $_GET["product_id"]; ?>&Action=ConfirmDelete';">
                </td>
                <td><input type="button" value="Cancel" OnClick="window.location='product.php?sort=&Action=All'"></td>
            </tr>
        </table>
    </center>
<?php
$result->free_result();
break;
}

//when confirm delete from delete product page was clicked
case "ConfirmDelete":{
//delete the link between product and category in sql database
$query = "DELETE FROM ProductCategory WHERE product_id =" . $_GET["product_id"];
$result = $conn->query($query) or die('Error querying database.');
$query1 = "DELETE FROM Product WHERE product_id =" . $_GET["product_id"];
$result1 = $conn->query($query1) or die('Error querying database.');
if ($result1) {
?>
    <script language="JavaScript">
        alert("The selected record had been deleted successfully");
        window.location = 'product.php?sort=&Action=All';
    </script>
<?php

}else {
?>
    <script language="JavaScript">
        alert("Error deleting record");
    </script>

    <?php
    break;
}
    $result->free_result();
    $result1->free_result();
    $conn->close();
}
}
?>
</body>
</html>
