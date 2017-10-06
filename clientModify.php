<?php
session_start();
include "Authenticate.php";
ob_start();
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 27/10/2017
 * Time: 5:20pm
 */
ob_start();
?>
<script language="JavaScript">
    function numDigits(x) {
        return Math.max(Math.floor(Math.log10(Math.abs(x))), 0) + 1;
    }

    function validateClient() {
        var nameG = document.forms["form"]["client_gname"].value;
        var nameF = document.forms["form"]["client_fname"].value;
        var emailC = document.forms["form"]["client_email"].value;
        var passwordC = document.forms["form"]["client_password"].value;
        var phoneC = document.forms["form"]["client_phone"].value;
        var mobileC = document.forms["form"]["client_mobile"].value;
        var streetA = document.forms["form"]["client_street"].value;
        var suburbA = document.forms["form"]["client_suburb"].value;
        var stateA = document.forms["form"]["client_state"].value;
        var postcodeA = document.forms["form"]["client_pc"].value;
        var mailL = document.forms["form"]["client_mlist"].value;

        if (nameG == null || nameG == "") {
            alert("Given name cannot be empty");
            return false;
        }
        if (nameG.length > 50) {
            alert("Given name shouldn't be more than 50 characters");
            return false;
        }

        if (nameF == null || nameF == "") {
            alert("Family name cannot be empty");
            return false;
        }
        if (nameF.length > 50) {
            alert("Family name shouldn't be more than 50 characters");
            return false;
        }

        if (emailC.length > 50) {
            alert("Email shouldn't be more than 50 characters");
            return false;
        }

        if (passwordC.length > 40) {
            alert("Password shouldn't be more than 40 characters");
            return false;
        }

        if (streetA.length > 100) {
            alert("Street address shouldn't be more than 100 characters");
            return false;
        }

        if (suburbA.length > 40) {
            alert("Suburb shouldn't be more than 50 characters");
            return false;
        }

        if (stateA.length > 6) {
            alert("State shouldn't be more than 6 characters, should be just state code");
            return false;
        }
        if (postcodeA != null && postcodeA != "") {
            if (isNaN(postcodeA)) {
                alert("Postcode must be numbers");
                return false;
            } else if (postcodeA.length != 4) {
                alert("Postcode should be only 4 digit");
                return false;
            }
        }

        if (isNaN(phoneC)) {
            alert("Phone number must be numbers");
            return false;
        } else if (numDigits(phoneC) > 20) {
            alert("Phone number should be less than 20 digit");
            return false;
        }

        if (isNaN(mobileC)) {
            alert("Mobile number must be numbers");
            return false;
        } else if (numDigits(mobileC) > 20) {
            alert("Mobile number should be less than 20 digit");
            return false;
        }

        if (mailL != "Y" && mailL !="N") {
            alert("Mailing List should be either Y or N");
            return false;
        }

        return true;
    }
</script>
<html>
<head><title>client Modification </title></head>
<body>

<?php
include("menu.php");

$strAction = $_GET["Action"];
switch ($strAction) {
//when add button from client table page was clicked
case "Add": {
    ?>
    <center><h2>Add client</h2></center>
    <form method="post" name="form" action="clientModify.php?Action=CheckAdd" onsubmit="return validateClient();">
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
                <td><b>Password</b></td>
                <td><input type="text" size="20" name="client_password"></td>
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
            <input type="button" value="Return to List" OnClick="window.location='client.php?sort='">
        </center>
    </form>
<?php

break;
}
//when confirm add button from add client page was clicked
case "CheckAdd": {
$query = "INSERT INTO Client (client_gname, client_fname, client_email, client_password, client_phone, client_mobile, address_street, address_suburb, address_state, address_postcode, client_mlist) VALUES ('$_POST[client_gname]','$_POST[client_fname]','$_POST[client_email]','$_POST[client_password]','$_POST[client_phone]','$_POST[client_mobile]','$_POST[client_street]','$_POST[client_suburb]','$_POST[client_state]','$_POST[client_pc]','$_POST[client_mlist]')";
$result = $conn->query($query) or die('Error querying database.');

if ($result){
?>
    <script language="JavaScript">
        alert("New client successfully added to database");
        window.location = 'client.php?sort=';
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
//when update button from client table page was clicked
case "Update": {
$query = "SELECT * FROM client WHERE client_id=" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database');
$rowC = $result->fetch_assoc();
?>
    <form method="post" name="form" action="clientModify.php?client_id=<?php echo $_GET["client_id"]; ?>&Action=ConfirmUpdate" onsubmit="return validateClient();">
        <center><h3>Client Details</h3></center>
        <br>
        <table border="3" align="center" cellpadding="3">
            <tr>
                <td><b>Given Name</b></td>
                <td><input type="text" size="20" name="client_gname" value="<?php echo $rowC["client_gname"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Family Name</b></td>
                <td><input type="text" size="20" name="client_fname" value="<?php echo $rowC["client_fname"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Street</b></td>
                <td><input type="text" size="20" name="client_street" value="<?php echo $rowC["address_street"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Suburb</b></td>
                <td><input type="text" size="20" name="client_suburb" value="<?php echo $rowC["address_suburb"]; ?>"></td>
            </tr>
            <tr>
                <td><b>State</b></td>
                <td><input type="text" size="20" name="client_state" value="<?php echo $rowC["address_state"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Postcode</b></td>
                <td><input type="text" size="20" name="client_pc" value="<?php echo $rowC["address_postcode"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><input type="text" size="20" name="client_email" value="<?php echo $rowC["client_email"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Password</b></td>
                <td><input type="text" size="20" name="client_password" value="<?php echo $rowC["client_password"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Home Phone</b></td>
                <td><input type="text" size="20" name="client_phone" value="<?php echo $rowC["client_phone"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Mobile</b></td>
                <td><input type="text" size="20" name="client_mobile" value="<?php echo $rowC["client_mobile"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Mailing List</b></td>
                <td><input type="text" size="20" name="client_mlist" value="<?php echo $rowC["client_mlist"]; ?>"></td>
            </tr>
        </table>

        <center>
            <input type="submit" value="Update client"">
            <input type="button" value="Return to List" OnClick="window.location='client.php?sort='">
        </center>
    </form>

<?php
$result->free_result();
break;
}

//when confirm update button from update client page was clicked
case "ConfirmUpdate": {
$query = "UPDATE Client SET client_gname='$_POST[client_gname]', client_fname='$_POST[client_fname]',client_email='$_POST[client_email]',client_password='$_POST[client_password]',client_phone='$_POST[client_phone]',client_mobile='$_POST[client_mobile]',address_street='$_POST[client_street]',address_suburb='$_POST[client_suburb]',address_state='$_POST[client_state]',address_postcode='$_POST[client_pc]',client_mlist='$_POST[client_mlist]' WHERE client_id=".$_GET["client_id"];
$result = $conn->query($query) or die('Error querying database.');

if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been updated successfully");
        window.location = 'client.php?sort=';
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
//when delete button from client table page was clicked
case "Delete": {
$query = "SELECT * FROM client WHERE client_id=" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database');
$rowC = $result->fetch_assoc();
?>
    <center>
        <h3> Are you sure you want to delete this record?</h3>
        <table border="3" cellpadding="3">
            <tr>
                <td><b>client ID</b></td>
                <td><?php echo $rowC["client_id"]; ?></td>
            </tr>
            <tr>
                <td><b>client Name</b></td>
                <td><?php echo $rowC["client_gname"]; ?> <?php echo $rowC["client_fname"]; ?></td>
            </tr>
        </table>
        <table align="center">
            <tr>
                <td><input type="submit" value="Confirm"
                           OnClick="window.location='clientModify.php?client_id=<?php echo $_GET["client_id"]; ?>&Action=ConfirmDelete';">
                </td>
                <td><input type="button" value="Cancel" OnClick="window.location='client.php?sort='"></td>
            </tr>
        </table>
    </center>
<?php
$result->free_result();
break;
}

//when confirm delete button from delete project page was clicked
case "ConfirmDelete":{
$query = "DELETE FROM client WHERE client_id =" . $_GET["client_id"];
$result = $conn->query($query) or die('Error querying database.');
if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been deleted successfully");
        window.location = 'client.php?sort=';
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
