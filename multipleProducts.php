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
?>
<script language="JavaScript">
    function numDigits(x) {
        return Math.max(Math.floor(Math.log10(Math.abs(x))), 0) + 1;
    }

    function validatePrice(number) {
        var rowNumber = parseInt(number);
        var rowCounter = 1;
        var purchaseP;
        var saleP;
        while (rowCounter <= rowNumber) {
            var pur = "purchase".concat(rowCounter.toString());
            var sal = "sale".concat(rowCounter.toString());
            purchaseP = document.forms["form"][pur].value;
            saleP = document.forms["form"][sal].value;

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
            rowCounter ++;
       }
        return true;
    }
</script>

<?php
include ("menu.php");

?>

<head>
    <title>Famox Products </title>
</head>
<body>
<?php
$strAction = $_GET["Action"];

switch ($strAction) {
    //display product price tables
    case "View": {
    //rowNumber is used for input validation, match input box name
    $query = "SELECT * FROM Product";
    $result = $conn->query($query);
    $rowNumber = $result->num_rows;
    $result->free_result();
        ?>
        <form method="post" name="form" action="multipleProducts.php?Action=ConfirmUpdate" onsubmit="return validatePrice(<?php echo $rowNumber?>);">
            <center><h2> All Products</h2></center>
            <table border="1" align="center">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Purchase Price</th>
                    <th>Sale Price</th>
                </tr>
                <?php
                $query = "SELECT * FROM Product";
                $result = $conn->query($query);
                //assign input box name with row number
                $rowCounter = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["product_id"]; ?></td>
                        <td><?php echo $row["product_name"]; ?></td>
                        <td><input type="text" name="<?php echo "purchase".$rowCounter; ?>"
                                   value="<?php echo $row["product_purchase_price"]; ?>"></td>
                        <td><input type="text" name="<?php echo "sale".$rowCounter; ?>"
                                   value="<?php echo $row["product_sale_price"]; ?>"></td>
                    </tr>
                    <?php
                    $rowCounter ++;
                }
                $result->free_result();
                ?>
            </table>
            <center><input type="submit" value="Update all products"></center>
        </form>
        <?php
        break;
    }

    //when update button was clicked
    case "ConfirmUpdate": {
        $query = "SELECT * FROM Product";
        $result = $conn->query($query);
        $rowCounter = 1;
        while ($row = $result->fetch_assoc()) {
            $purStr = "purchase" . $rowCounter;
            $purchase = $_POST[$purStr];
            $saleStr = "sale" . $rowCounter;
            $sale = $_POST[$saleStr];
            $id = $row['product_id'];
            $query1 = "UPDATE Product SET product_purchase_price='$purchase',product_sale_price='$sale' WHERE product_id='$id'";
            $result1 = $conn->query($query1) or die('Error querying database.');
            $rowCounter++;
        }
        if ($result) {
            ?>
            <script language="JavaScript">
                alert("The selected record had been updated successfully");
                window.location = 'multipleProducts.php?Action=View';
            </script>
            <?php
        }else
            ?>
            <script language="JavaScript">
                alert("Error updating record. Please contact System Administrator");
                window.location = 'multipleProducts.php?Action=View';
            </script>
            <?php
        $result->free_result();
    }
        $conn->close();
}
?>
</body>
