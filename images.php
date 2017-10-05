<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 22/09/2017
 * Time: 3:43 PM
 */
include "menu.php";

$strAction = $_GET["Action"];
switch ($strAction) {
//display all images
case "View": {
$query = "select * from ProductImage";
$result = $conn->query($query);
if ($result->num_rows != 0) {
?>
<center>
    <form method="post" enctype="multipart/form-data" action="images.php?&Action=Delete">
        <h3>Delete images</h3>
        <table border="2">
            <tr>
            <?php
            //show 4 images per row
            $x = 0;
            while ($row= $result->fetch_assoc()) {
                if ($x < 4){
                    $x++;
                } else {
                ?>
                </tr><tr>
                <?php $x = 0;
                }
                $query1 = "select product_name from Product where product_id='$row[product_id]'";
                $result1 = $conn->query($query1);
                $name = $result1->fetch_assoc()
                ?>
                <td>
                    <div>
                        <div align="top"><?php echo "Product: ".$name["product_name"]?></div>
                        <div ><?php echo "<img src=\"product_images/" . $row["image_name"] . "\" width=\"280\" height=\"200\" border=0>"; ?></div>
                        <div align="right"  style="vertical-align: bottom;"> <?php echo $row["image_name"] ?> <input type="checkbox" name="checkImage[]" size="30" value="<?php echo $row["image_id"] ?>"></div>
                    </div>
                </td>
                <?php
                $result1->free_result();
            }?>
            </tr>
        </table>
        <input type="submit" value="Delete select images">
    </form>
    <?php }?>
</center>
<?php
    $result->free_result();
    break; }

//when delete button was clicked
case "Delete":{
    if (!empty($_POST["checkImage"])) {
        foreach ($_POST["checkImage"] as $image_id) {
            $query = "Select image_name FROM ProductImage WHERE image_id = '$image_id'";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $nameI = "product_images/".$row["image_name"];
            if (!unlink($nameI)) {
                ?>
                <script language="JavaScript">
                    alert("Error deleting image <?php echo $nameI?> from product images folder. Please contact the system administrator");
                    window.location = "images.php?Action=View";
                </script>
                <?php

            } else {
                $query = "DELETE FROM ProductImage WHERE image_id = '$image_id'";
                if (!($conn->query($query))){
                    ?>
                    <script language="JavaScript">
                        alert("Error deleting image from database. Please contact the system administrator  ");
                        window.location = "images.php?Action=View";
                    </script>
                    <?php
                } else {
                    ?>
                    <script language="JavaScript">
                        alert("The selected files had been deleted");
                        window.location = "images.php?Action=View";
                    </script>
                    <?php
                }

            }
        }
    } else {
        ?>
        <script language="JavaScript">
            alert("No images selected");
            window.location = "images.php?Action=View";
        </script>
        <?php
    }
    $result->free_result();
    break;
}
} ?>