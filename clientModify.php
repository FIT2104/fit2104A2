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
ob_start();
?>
<html>
<head><title>client Modification </title></head>
<body>

<?php
include("menu.php");

$strAction = $_GET["Action"];
switch ($strAction) {

case "Add": {
    ?>
    <center><h2>Add client</h2></center>
    <form method="post" name="myform" ; action="clientModify.php?Action=CheckAdd">
        <table border="3" align="center">
            <tr>
                <td><b>Given Name</b></td>
                <td><input type="text" size="20" name="client_gname"></td>
            </tr>
            <tr>
                <td><b>Family Name</b></td>
                <td><input type="text" size="20" name="client_fname"></td>
            </tr>
            <tr>
                <td><b>Street</b></td>
                <td><input type="text" size="20" name="client_street"></td>
            </tr>
            <tr>
                <td><b>Suburb</b></td>
                <td><input type="text" size="20" name="client_suburb"></td>
            </tr>
            <tr>
                <td><b>State</b></td>
                <td><input type="text" size="20" name="client_state"></td>
            </tr>
            <tr>
                <td><b>Postcode</b></td>
                <td><input type="text" size="20" name="client_pc"></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><input type="text" size="20" name="client_email"></td>
            </tr>
            <tr>
                <td><b>Home Phone</b></td>
                <td><input type="text" size="20" name="client_phone"></td>
            </tr>
            <tr>
                <td><b>Mobile</b></td>
                <td><input type="text" size="20" name="client_mobile"></td>
            </tr>
            <tr>
                <td><b>Mailing List</b></td>
                <td><input type="text" size="20" name="client_mlist"></td>
            </tr>
        </table>
        <?php
        ?>
        <center>
            <input type="submit" value="Add client">
            <input type="button" value="Return to List" OnClick="window.location='client.php'">
        </center>
    </form>
<?php

break;
}

case "CheckAdd": {
$query = "INSERT INTO address (street, suburb, state, postcode) VALUES ('$_POST[client_street]','$_POST[client_suburb]','$_POST[client_state]','$_POST[client_pc]')";
$result = $conn->query($query);
if ($result) {
    $query1 = "SELECT address_id FROM address WHERE street = $_POST[client_street] AND"." suburb = $_POST[client_suburb] AND postcode = $_POST[client_pc]";
    $result1 = $conn->query($query1);
    if ($result1->num_rows > 0) {
        while($row = mysqli_fetch_array($result1)) {
            $addID = $row['address_id'];
        }
        $query2 = "INSERT INTO client (client_gname, client_fname, client_email, client_password, client_phone, client_mobile, client_mlist, address_id) VALUES ('$_POST[client_gname]','$_POST[client_fname]','$_POST[client_email]','$_POST[client_phone]','$_POST[client_mobile]','$_POST[client_mlist]','$addID')";
        $result2 = $conn->query($query2);
    }
}
if ($result2){
?>
    <script language="JavaScript">
        alert("New client successfully added to database");
        window.location = 'client.php';
    </script>
<?php
} else {
?>
    <script language="JavaScript">
        alert("Error adding record. Please contact System Administrator");
        window.location = 'clientModify.php?Action=Add';
    </script>
<?php
}
$result->free_result();
$conn->close();
break;
}

case "Update": {
$query = "SELECT * FROM client WHERE client_id=" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database');
$rowP = $result->fetch_assoc();
?>
    <form method="post" action="clientModify.php?client_id=<?php echo $_GET["client_id"]; ?>&Action=ConfirmUpdate">
        <center><h3>client Details</h3></center>
        <br>
        <table border="3" align="center" cellpadding="3">
            <tr>
                <td><b>client Name</b></td>
                <td><input type="text" name="name" value="<?php echo $rowP["client_name"]; ?>"></td>
            </tr>
            <tr>
                <td><b>client Description</b></td>
                <td><input type="text" name="desc" value="<?php echo $rowP["client_description"]; ?>"></td>
            </tr>
        </table>

        <center>
            <input type="submit" value="Update client"">
            <input type="button" value="Return to List" OnClick="window.location='client.php'">
        </center>
    </form>

<?php
$result->free_result();
break;
}

case "ConfirmUpdate": {
$name = $_POST['name'];
$desc = $_POST['desc'];
$id = $_GET['client_id'];
$query = "UPDATE client SET client_name='$name',client_description='$desc'WHERE client_id='$id'";
$result = $conn->query($query) or die('Error querying database.');

if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been updated successfully");
        window.location = 'client.php';
    </script>
<?php
}else
?>
    <script language="JavaScript">
        alert("Error updating record. Please contact System Administrator");
    </script>
<?php
$result->free_result();
$conn->close();
break;

}

case "Delete": {
$query = "SELECT * FROM client WHERE client_id=" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database');
$rowP = $result->fetch_assoc();
?>
    <center>
        <h3> Are you sure you want to delete this record?</h3>
        <table border="3" cellpadding="3">
            <tr>
                <td><b>client ID</b></td>
                <td><?php echo $rowP["client_id"]; ?></td>
            </tr>
            <tr>
                <td><b>client Name</b></td>
                <td><?php echo $rowP["client_name"]; ?></td>
            </tr>
        </table>
        <table align="center">
            <tr>
                <td><input type="submit" value="Confirm"
                           OnClick="window.location='clientModify.php?client_id=<?php echo $_GET["client_id"]; ?>&Action=ConfirmDelete';">
                </td>
                <td><input type="button" value="Cancel" OnClick="window.location='client.php'"></td>
            </tr>
        </table>
    </center>
<?php
$result->free_result();
break;
}

case "ConfirmDelete":{
$query = "DELETE FROM client WHERE client_id =" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database.');
if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been deleted successfully");
        window.location = 'client.php';
    </script>
<?php
}else {
?>
    <script language="JavaScript">
        alert("Error deleting record. Please contact system administrator.");
    </script>

    <?php
    break;
}
    $result->free_result();
    $conn->close();
}
}
?>
</body>
</html>
