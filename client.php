<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 27/10/2017
 * Time: 5:00pm
 */
include("menu.php");
//the function that return the sorting query depend on sort type
function sortType()
{
    switch ($_GET['sort']) {
        case "idA":
            return " ORDER BY client_id ASC";
            break;

        case "nameA":
            return " ORDER BY client_name ASC";
            break;

        case "emailA":
            return " ORDER BY client_email ASC";
            break;

        case "mailA":
            return " ORDER BY client_mlist ASC";
            break;

        case "idD":
            return " ORDER BY client_id DESC";
            break;

        case "nameD":
            return " ORDER BY client_name DESC";
            break;

        case "emailD":
            return " ORDER BY client_email DESC";
            break;

        case "mailD":
            return " ORDER BY client_mlist DESC";
            break;

        default:
            return "";
            break;
    }
}
?>
<html>
<head>
    <title>Famox Clients</title>
</head>
<body>
<center><h2> Clients </h2></center>
<table border="1" align="center">
    <tr>
        <th><?php if ($_GET['sort']=='idA'){?><a href="client.php?sort=idD">Client ID</a> <?php } else { ?><a href="client.php?sort=idA">Client ID</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='nameA'){?><a href="client.php?sort=nameD">Name</a> <?php } else { ?><a href="client.php?sort=nameA">Name</a> <?php } ?></th>
        <th><?php if ($_GET['sort']=='emailA'){?><a href="client.php?sort=emailD">Email</a> <?php } else { ?><a href="client.php?sort=emailA">Email</a> <?php } ?></th>
        <th>Password</th>
        <th>Phone</th>
        <th>Mobile</th>
        <th>Address</th>
        <th><?php if ($_GET['sort']=='mailA'){?><a href="client.php?sort=mailD">Mailing List</a> <?php } else { ?><a href="client.php?sort=mailA">Mailing List</a> <?php } ?></th>

    </tr>
    <?php
    $orderBy = sortType();
    $query = "SELECT * FROM Client".$orderBy;
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row["client_id"]; ?></td>
            <td><?php echo $row["client_gname"]; ?> <?php echo $row["client_fname"]; ?></td>
            <td><?php echo $row["client_email"]; ?></td>
            <td><?php echo $row["client_password"]; ?></td>
            <td><?php echo $row["client_phone"]; ?></td>
            <td><?php echo $row["client_mobile"]; ?></td>
            <td><?php echo $row["address_street"]; ?>, <?php echo $row["address_suburb"]; ?>, <?php echo $row["address_state"]; ?> <?php echo $row["address_postcode"]; ?></td>
            <td><?php echo $row["client_mlist"]; ?></td>
            <br>
            <td>
                <a href="clientModify.php?client_id=<?php echo $row["client_id"]; ?>&Action=Update">Update</a>
            </td>
            <td>
                <a href="clientModify.php?client_id=<?php echo $row["client_id"]; ?>&Action=Delete">Delete</a>
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
            <input type="button" value="Add New Client" OnClick="window.location='clientModify.php?Action=Add'">
        </center>
    </table>
    <table>
        <td align="center">
            <div class="round-button">
                <a href="sourceCode.php?destination=client.php" target="_blank">
                    <img name="myImg" src="images/client.png" alt="Client Source Code"/>
                </a>
            </div>
        </td>
    </table>

</body>
</html>