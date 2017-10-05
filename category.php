<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 17/09/2017
 * Time: 10:02 PM
 */
include("menu.php");

//the function that return the sorting query depend on sort type
function sortType()
{
    switch ($_GET['sort']) {
        case "idA":
            return " ORDER BY category_id ASC";
            break;

        case "nameA":
            return " ORDER BY category_name ASC";
            break;

        case "idD":
            return " ORDER BY category_id DESC";
            break;

        case "nameD":
            return " ORDER BY category_name DESC";
            break;

        default:
            return "";
            break;
    }
}

?>
<html>
<head>
    <title>Famox Products Categories</title>
</head>
<body>
<center><h2> Products Categories</h2></center>
<table border="1" align="center">
    <tr>
        <th><?php if ($_GET['sort']=='idA'){?><a href="category.php?sort=idD&Action=All">Category ID</a> <?php } else { ?><a href="category.php?sort=idA">Category ID</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='nameA'){?><a href="category.php?sort=nameD&Action=All">Category Name</a> <?php } else { ?><a href="category.php?sort=nameA">Category Name</a> <?php } ?></th>
        <th>Description</th>
    </tr>
    <?php
    $orderType = sortType();
    $query = "SELECT * FROM Category" . $orderType;
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row["category_id"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["category_description"]; ?></td>
            <br>
            <td>
                <a href="categoryModify.php?category_id=<?php echo $row["category_id"]; ?>&Action=Update">Update</a>
            </td>
            <td>
                <a href="categoryModify.php?category_id=<?php echo $row["category_id"]; ?>&Action=Delete">Delete</a>
            </td>
        </tr>

        <?php
    }
    $result->free_result();
    $conn->close();
    ?>
</table>

    <table>
        <center>
            <br/>
            <input type="button" value="Add new category" OnClick="window.location='categoryModify.php?Action=Add'">
        </center>
    </table>


    </a>
    <table>
        <td align="center">
            <div class="round-button">
                <a href="sourceCode.php?destination=category.php" target="_blank">
                    <img name="myImg" src="images/category.png" alt="Category Source Code"/>
                </a>
            </div>
        </td>
    </table>

</body>
</html>