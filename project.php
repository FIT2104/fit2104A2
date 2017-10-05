<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 17/09/2017
 * Time: 11:42 PM
 */
include("menu.php");
//the function that return the sorting query depend on sort type
function sortType()
{
    switch ($_GET['sort']) {
        case "idA":
            return " ORDER BY project_id ASC";
            break;

        case "cityA":
            return " ORDER BY project_city ASC";
            break;

        case "countryA":
            return " ORDER BY project_country ASC";
            break;

        case "raiseA":
            return " ORDER BY raise_amount ASC";
            break;

        case "idD":
            return " ORDER BY project_id DESC";
            break;

        case "cityD":
            return " ORDER BY project_city DESC";
            break;

        case "countryD":
            return " ORDER BY project_country DESC";
            break;

        case "raiseD":
            return " ORDER BY raise_amount DESC";
            break;

        default:
            return "";
            break;
    }
}

?>
<html>
<head>
    <title>Famox Projects</title>
</head>
<body>
<center><h2> Projects </h2></center>
<table border="1" align="center">
    <tr>
        <th><?php if ($_GET['sort']=='idA'){?><a href="project.php?sort=idD">Project ID</a> <?php } else { ?><a href="project.php?sort=idA">Project ID</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='cityA'){?><a href="project.php?sort=cityD">City Location</a> <?php } else { ?><a href="project.php?sort=cityA">City Location</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='countryA'){?><a href="project.php?sort=countryD">Country Location</a> <?php } else { ?><a href="project.php?sort=countryA">Country Location</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='raiseA'){?><a href="project.php?sort=raiseD">Raise Amount</a> <?php } else { ?><a href="project.php?sort=raiseA">Raise Amount</a> <?php } ?></th>
    </tr>
    <?php
    $orderBy = sortType();
    $query = "SELECT * FROM Project" . $orderBy;
    $result = $conn->query($query) or die('Error querying database.');

    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row["project_id"]; ?></td>
            <td><?php echo $row["project_city"]; ?></td>
            <td><?php echo $row["project_country"]; ?></td>
            <td><?php echo $row["project_description"]; ?></td>
            <td><?php echo $row["raise_amount"]; ?></td>
            <br>
            <td>
                <a href="projectModify.php?project_id=<?php echo $row["project_id"]; ?>&Action=Update">Update</a>
            </td>
            <td>
                <a href="projectModify.php?project_id=<?php echo $row["project_id"]; ?>&Action=Delete">Delete</a>
            </td>
        </tr>

        <?php
    }
    $result->free_result();
    $conn->close();
    ?>

    <table>
        <center>
            <br/>
            <input type="button" value="Add new project" OnClick="window.location='projectModify.php?Action=Add'">
        </center>
    </table>

</body>


</html>