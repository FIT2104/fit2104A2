<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 15/09/2017
 * Time: 8:13 PM
 */
include ("menu.php");
//the function that return the sorting query depend on sort type
function sortType(){
    switch($_GET['sort']){
        case "idA":
            return " ORDER BY product_id ASC";
            break;

        case "nameA":
            return " ORDER BY product_name ASC";
            break;

        case "purchaseA":
            return " ORDER BY product_purchase_price ASC";
            break;

        case "saleA":
            return " ORDER BY product_sale_price ASC";
            break;

        case "countryA":
            return " ORDER BY product_country ASC";
            break;

        case "idD":
            return " ORDER BY product_id DESC";
            break;

        case "nameD":
            return " ORDER BY product_name DESC";
            break;

        case "purchaseD":
            return " ORDER BY product_purchase_price DESC";
            break;

        case "saleD":
            return " ORDER BY product_sale_price DESC";
            break;

        case "countryD":
            return " ORDER BY product_country DESC";
            break;

        default:
            return "";
            break;
    }
}
?>
<html>
<head>
    <title>Famox Products </title>
</head>
<?php
$strAction = $_GET["Action"];

switch ($strAction) {
    //display all product records
    case "All": {?>
        <body>
        <center><h2> All Products</h2></center>
        <table border="1" align="center">
            <tr>
                <th><?php if ($_GET['sort']=='idA'){?><a href="product.php?sort=idD&Action=All">Product ID</a> <?php } else { ?><a href="product.php?sort=idA&Action=All">Product ID</a> <?php } ?></th>
                <th><?php if ($_GET['sort']=='nameA'){?><a href="product.php?sort=nameD&Action=All">Product Name</a> <?php } else { ?><a href="product.php?sort=nameA&Action=All">Product Name</a> <?php } ?></th>
                <th><?php if ($_GET['sort']=='purchaseA'){?><a href="product.php?sort=purchaseD&Action=All">Purchase Price</a> <?php } else { ?><a href="product.php?sort=purchaseA&Action=All">Purchase Price</a> <?php } ?></th>
                <th><?php if ($_GET['sort']=='saleA'){?><a href="product.php?sort=saleD&Action=All">Sale Price</a> <?php } else { ?><a href="product.php?sort=saleA&Action=All">Sale Price</a> <?php } ?></th>
                <th><?php if ($_GET['sort']=='countryA'){?><a href="product.php?sort=countryD&Action=All">Country of Origin</a> <?php } else { ?><a href="product.php?sort=countryA&Action=All">Country of Origin</a> <?php } ?></th>
                <th>Description</th>
                <th>Category</th>
            </tr>
            <?php

            $orderBy = sortType();
            $query = "SELECT * FROM Product" . $orderBy;
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $query1 = "SELECT * FROM ProductCategory WHERE product_id='$row[product_id]'";
                $result1 = $conn->query($query1);
                $category_string = "";
                while ($catPro = $result1->fetch_assoc()) {
                    $query2 = "SELECT * FROM Category WHERE category_id='$catPro[category_id]'";
                    $result2 = $conn->query($query2);

                    //get product's categories
                    while ($cat = $result2->fetch_assoc()) {
                        $category_string = $category_string . "-" . $cat["category_name"];
                    }
                    $result2->free_result();
                }
                $result1->free_result();
                ?>
                <tr>
                    <td><?php echo $row["product_id"]; ?></td>
                    <td><?php echo $row["product_name"]; ?></td>
                    <td><?php echo $row["product_purchase_price"]; ?></td>
                    <td><?php echo $row["product_sale_price"]; ?></td>
                    <td><?php echo $row["product_country"]; ?></td>
                    <td><?php echo $row["product_description"]; ?></td>
                    <td><?php echo "$category_string"; ?></td>
                    <br>
                    <td>
                        <a href="productModify.php?product_id=<?php echo $row["product_id"]; ?>&Action=Update">Update</a>
                    </td>
                    <td>
                        <a href="productModify.php?product_id=<?php echo $row["product_id"]; ?>&Action=Delete">Delete</a>
                    </td>
                </tr>

                <?php
            }
            $result->free_result();
            ?>
        </table>
        <center>
            <br/>
            <form name="search" method="post" action="product.php?Action=Search">
                <input name="search" type="text" size="40" maxlength="30">
                <input name="submit" type="submit" value="search by category">
            </form>
            <center>
                <input type="button" value="Add new product" OnClick="window.location='productModify.php?Action=Add'">

            </center>
        </center>
        </body>
        <?php
        break;}

//display target searched product records
case "Search": {
    $search_string = $_POST['search'];
    //check search box cannot be empty
    if (empty($search_string)) {
        ?>
        <script language="JavaScript">
            alert("The input can not be null");
            window.location = 'Product.php?sort=&Action=All';
        </script>
        <?php
    }

    //check if search result match any category type
    $query = "SELECT *  FROM Category where category_name like '%$search_string%'";
    $result = $conn->query($query);
    if ($result->num_rows > 0){
    ?>
    <body>
    <center><h2>Search result: <?php echo "$search_string"?></h2></center>
    <table border="1" align="center">
        <tr>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Purchase Price</th>
            <th>Sale Price</th>
            <th>Country of Origin</th>
            <th>Description</th>
        </tr>
        </tr>
        <tbody>
        <?php
        $total_record = 0;
        while ($cat = $result->fetch_assoc()) {
            $query1 = "SELECT product_id FROM ProductCategory where category_id = '$cat[category_id]'";
            $result1 = $conn->query($query1);

            while ($catPro = $result1->fetch_assoc()) {

                $query2 = "SELECT * FROM Product where product_id = '$catPro[product_id]'";
                $result2= $conn->query($query2);
                $total_record= $result2->num_rows;
                while ($row = $result2->fetch_assoc()) {
                    $query3="SELECT * FROM ProductCategory WHERE product_id='$row[product_id]'";
                    $result3 = $conn->query($query3);
                    $category_string = "";
                    while ($catPro = $result3->fetch_assoc()){
                        $query4="SELECT * FROM Category WHERE category_id='$catPro[category_id]'";
                        $result4 = $conn->query($query4);
                        //join all the categories type of the product together into a string
                        while ($cat = $result4->fetch_assoc()) {
                            $category_string = $category_string . "-" . $cat["category_name"];
                        }
                        $result4->free_result();
                    }
                    $result3->free_result();
                    ?>
                    <tr>
                        <td><?php echo $row["product_id"]; ?></td>
                        <td><?php echo $row["product_name"]; ?></td>
                        <td><?php echo $row["product_purchase_price"]; ?></td>
                        <td><?php echo $row["product_sale_price"]; ?></td>
                        <td><?php echo $row["product_country"]; ?></td>
                        <td><?php echo $row["product_description"]; ?></td>
                        <td><?php echo "$category_string";?></td>
                        <br>
                        <td>
                            <a href="productModify.php?product_id=<?php echo $row["product_id"]; ?>&Action=Update">Update</a>
                        </td>
                        <td>
                            <a href="productModify.php?product_id=<?php echo $row["product_id"]; ?>&Action=Delete">Delete</a>
                        </td>
                    </tr>

                    <?php
                }
                $result2->free_result();
            }
            $result1->free_result();

        }
        $result->free_result();
        ?>
        </tbody>

        </table>
        <center>
            <input type="button" value="Go Back" OnClick="window.location='product.php?sort=&Action=All'">
        </center>
        <?php
        if ($total_record == 0) {
            ?>
            <script language="JavaScript">
                alert("There are no products in this category");
                window.location = 'product.php?sort=&Action=All';
            </script>
            <?php

        }
        } else {
            ?>
            <script language="JavaScript">
                alert("Category not found");
                window.location = 'product.php?sort=&Action=All';
            </script>
            <?php
        }
        break;
    }
}
        $conn->close();
?>
    </body>
</html>