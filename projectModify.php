<?php
session_start();
include "Authenticate.php";
ob_start();
/**
* Created by PhpStorm.
* User: Tim
* Date: 17/09/2017
* Time: 12:22 PM
*/
?>
<script language="JavaScript">
    function numDigits(x) {
        return Math.max(Math.floor(Math.log10(Math.abs(x))), 0) + 1;
    }

    function validateProject() {
        var cityL = document.forms["form"]["city"].value;
        var countryL = document.forms["form"]["country"].value;
        var descP = document.forms["form"]["desc"].value;
        var amountR = document.forms["form"]["amount"].value;

        if (cityL == null || cityL == "") {
            alert("City cannot be empty");
            return false;
        }
        if (cityL.length > 50) {
            alert("City shouldn't be more than 50 characters");
            return false;
        }
        if (countryL == null || countryL == "") {
            alert("Country cannot be empty");
            return false;
        }
        if (countryL.length > 40) {
            alert("Country shouldn't be more than 40 characters");
            return false;
        }
        if (descP == null || descP == "") {
            alert("Project Description cannot be empty");
            return false;
        }
        if (descP.length > 100) {
            alert("Project description shouldn't be more than 100 characters");
            return false;
        }
        if (amountR == null || amountR == "") {
            alert("Raise amount cannot be empty");
            return false;
        } else if (isNaN(amountR)) {
            alert("Amount Raise must be numbers");
            return false;
        } else if (numDigits(amountR) > 10) {
            alert("Amount Raise should be less than 10 digit");
            return false;
        }
        return true;
        }
</script>
<?php
ob_start();
include("menu.php");
?>

<html>
<head><title>Project Modification </title></head>
<body>

<?php
$strAction = $_GET["Action"];
switch ($strAction) {

//when add button from project table page was clicked
case "Add": {
    ?>
    <center><h2>Add project</h2></center>
    <form method="post" name="form" action="projectModify.php?Action=ConfirmAdd" onsubmit="return validateProject();">
        <table border="3" align="center">
            <tr>
                <td><b>Project City</b></td>
                <td><input type="text" size="20" name="city"></td>
            </tr>
            <tr>
                <td><b>Project Country</b></td>
                <td><input type="text" size="20" name="country"></td>
            </tr>
            <tr>
                <td><b>Project Description</b></td>
                <td><input type="text" size="20" name="desc"></td>
            </tr>
            <tr>
                <td><b>Project Raise Amount</b></td>
                <td><input type="text" size="20" name="amount"></td>
            </tr>
        </table>
        <?php
        ?>
        <center>
            <input type="submit" value="Add project">
            <input type="button" value="Return to List " OnClick="window.location='project.php?sort='">
        </center>
    </form>
<?php

break;
}

//when confirm add button from add project page was clicked
case "ConfirmAdd": {
$query = "INSERT INTO `project`(`project_city`, `project_country`, `project_description`, `raise_amount`) VALUES ('$_POST[city]','$_POST[country]','$_POST[desc]','$_POST[amount]')";
$result = $conn->query($query)or die('Error querying database.');
if ($result){
?>
    <script language="JavaScript">
        alert("New project successfully added to database");
        window.location = 'project.php?sort=';
    </script>
<?php
} else {
?>
    <script language="JavaScript">
        alert("Error adding record. Please contact System Administrator");
        window.location = 'projectModify.php?Action=Add';
    </script>
<?php
}
$result->free_result();
$conn->close();
break;
}

//when update button from project table page was clicked
case "Update": {
$query = "SELECT * FROM project WHERE project_id=" . $_GET["project_id"];
$result = $conn->query($query) or die('Error querying database');
$rowP = $result->fetch_assoc();
?>
    <form method="post" name="form" action="projectModify.php?project_id=<?php echo $_GET["project_id"]; ?>&Action=ConfirmUpdate"  onsubmit="return validateProject();">
        <center><h3>Project Details</h3></center>
        <br>
        <table border="3" align="center" cellpadding="3">
            <tr>
                <td><b>Project City</b></td>
                <td><input type="text" name="city" value="<?php echo $rowP["project_city"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Project Country</b></td>
                <td><input type="text" name="country" value="<?php echo $rowP["project_country"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Project Description</b></td>
                <td><input type="text" name="desc" value="<?php echo $rowP["project_description"]; ?>"></td>
            </tr>
            <tr>
                <td><b>Project Raise Amount</b></td>
                <td><input type="text" name="amount" value="<?php echo $rowP["raise_amount"]; ?>"></td>
            </tr>
        </table>

        <center>
            <input type="submit" value="Update project"">
            <input type="button" value="Return to List" OnClick="window.location='project.php?sort='">
        </center>
    </form>

<?php
$result->free_result();
break;
}

//when confirm update button from update project page was clicked
case "ConfirmUpdate": {
$city= $_POST['city'];
$country= $_POST['country'];
$desc = $_POST['desc'];
$amount = $_POST['amount'];
$id = $_GET['project_id'];
$query = "UPDATE Project SET project_city='$city',project_country='$country',project_description='$desc',raise_amount='$amount' WHERE project_id=".$_GET["project_id"];
$result = $conn->query($query) or die('Error querying database.');

if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been updated successfully");
        window.location = 'project.php?sort=';
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

//when delete button from project table page was clicked
case "Delete": {
$query = "SELECT * FROM Project WHERE project_id=" . $_GET["project_id"];
$result = $conn->query($query) or die('Error querying database');
$rowP = $result->fetch_assoc();
?>
    <center>
        <h3> Are you sure you want to delete this record?</h3>
        <table border="3" cellpadding="3">
            <tr>
                <td><b>Project ID</b></td>
                <td><?php echo $rowP["project_id"]; ?></td>
            </tr>
            <tr>
                <td><b>Project Description</b></td>
                <td><?php echo $rowP["project_description"]; ?></td>
            </tr>
            <tr>
                <td><b>Project Raise Amount</b></td>
                <td><?php echo $rowP["raise_amount"]; ?></td>
            </tr>
        </table>
        <table align="center">
            <tr>
                <td><input type="submit" value="Confirm"
                           OnClick="window.location='projectModify.php?project_id=<?php echo $_GET["project_id"]; ?>&Action=ConfirmDelete';">
                </td>
                <td><input type="button" value="Cancel" OnClick="window.location='project.php?sort='"></td>
            </tr>
        </table>
    </center>
<?php
$result->free_result();
break;
}

//when confirm delete button from delete project page was clicked
case "ConfirmDelete":{
$query = "DELETE FROM Project WHERE project_id =" . $_GET["project_id"];
$result = $conn->query($query) or die('Error querying database.');
if ($result) {
?>
    <script language="JavaScript">
        alert("The selected record had been deleted successfully");
        window.location = 'project.php?sort=';
    </script>
<?php
}else {
?>
    <script language="JavaScript">
        alert("Error deleting record. Please contact system administrator.");
        window.location = 'project.php?sort=';
    </script>

    <?php

}
    $result->free_result();
    $conn->close();
    break;
}
}
?>
<table>
    <td align="center">
        <div class="round-button">
            <a href="sourceCode.php?destination=projectModify.php" target="_blank">
                <img name="myImg" src="images/multiproject.png" alt="Multiple Projects Source Code"/>
            </a>
        </div>
    </td>
</table>
</body>
</html>
