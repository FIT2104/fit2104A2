<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Tim
 * Date:
 * Time:
 */
include("menu.php");

?>
<html>
<head>
    <title>Famox Clients</title>
</head>
<body>
<center><h2> Clients </h2></center>
<table border="1" align="center">
    <tr>
        <th>Client ID</th>
        <th>Name</th>
        <th>Street</th>
        <th>Suburb</th>
        <th>State</th>
        <th>Postcode</th>
        <th>Email</th>
        <th>Password</th>
        <th>Phone</th>
        <th>Mobile</th>
        <th>Mailing List</th>
    </tr>
    <?php
    $query = "SELECT * FROM Client";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row["client_id"]; ?></td>
            <td><?php echo $row["client_gname"]; ?> <?php echo $row["client_fname"]; ?></td>
            <td><?php echo $row["client_street"]; ?></td>
            <td><?php echo $row["client_suburb"]; ?></td>
            <td><?php echo $row["client_state"]; ?></td>
            <td><?php echo $row["client_pc"]; ?></td>
            <td><?php echo $row["client_email"]; ?></td>
            <td><?php echo $row["client_password"]; ?></td>
            <td><?php echo $row["client_phone"]; ?></td>
            <td><?php echo $row["client_mobile"]; ?></td>
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

</body>
</html>