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
<center><h1><img src="images/Famox.png" width="350" height="150"</h1></center>
<nav>
        <table border="3" align="center">
            <tr>
                <th><a href="login.php"> Login </a></th>
                <th><a href="product.php?sort=&Action=All"> Product </a></th>
                <th><a href="client.php?sort="> Client </a></th>
                <th><a href="sendEmail.php?Action=Show"> Send Emails</a></th>
                <th><a href="category.php?sort="> Category </a></th>
                <th><a href="project.php?sort="> Project </a></th>
                <th><a href="multipleProducts.php?Action=View"> Multiple Products </a></th>
                <th><a href="images.php?Action=View"> Images </a></th>
            </tr>
        </table>
    </nav>
<body>
</html>
