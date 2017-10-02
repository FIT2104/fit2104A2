<?php
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
                <td><b>First Name</b></td>
                <td><input type="text" size="20" name="gname"></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>
            <br/>
            <tr>
                <td><b>Street Address</b></td>
                <td><input type="text" size="20" name="street"></td>
            </tr>
            <tr>
                <td><b>Suburb </b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>          <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>
            <tr>
                <td><b>Last Name</b></td>
                <td><input type="text" size="20" name="fname"></td>
            </tr>



        </table>
        <?php
        ?>
        <center>
            <input type="submit" value="Add client">
            <input type="button" value="Return to List " OnClick="window.location='client.php'">
        </center>
    </form>
<?php

break;
}

case "CheckAdd": {
$query = "INSERT INTO client (client_name,client_description) VALUES ('$_POST[client_name]','$_POST[client_description]')";
$result = $conn->query($query);
if ($result){
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
