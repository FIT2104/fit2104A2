<?php
/**
 * Created by PhpStorm.
 * User: Aubrey
 * Date: 15/09/2017
 * Time: 8:13 PM
 */
include  ('connection.php');
?>
<html>
<center><h1><img src="images/Famox.png" width="350" height="220"</h1></center>
<center>
<?php

    if (isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == "success") {
        if (basename($_SERVER['PHP_SELF']) != "login.php") {
            echo "Signed in as " . $_SESSION['username'] . "!";
            ?>
            <input type="button" value="Sign Out" OnClick="window.location='login.php?Action=Show'">
            <?php
        }
    } else {
    if (basename($_SERVER['PHP_SELF']) != "login.php") {
        ?>
        <input type="button" value="Sign In" OnClick="window.location='login.php?Action=Show'">
        <?php
    }
    }?>
</center>
<nav>
        <table border="3" align="center">
            <tr>
                <th><a href="home.php"> Home </a></th>
                <th><a href="product.php?sort=&Action=All"> Product </a></th>
                <th><a href="client.php?sort="> Client </a></th>
                <th><a href="sendEmail.php?Action=Show"> Send Emails </a></th>
                <th><a href="pdfCreation.php"> Generate Pdf </a></th>
                <th><a href="category.php?sort="> Category </a></th>
                <th><a href="project.php?sort="> Project </a></th>
                <th><a href="multipleProducts.php?Action=View"> Multiple Products </a></th>
                <th><a href="images.php?Action=View"> Images </a></th>
                <th><a href="documentation.php"> Documentation</a></th>
            </tr>
        </table>
    </nav>
<body>
</html>
