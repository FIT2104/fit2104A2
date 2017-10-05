<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 **/
ob_start();
session_start();
$_SESSION["adminLogin"] = "false";
?>

<html>
<head>
    <title>Login to Famox</title>
</head>
<body>
<?php
if(empty($_POST["uname"]))
{
    ?>
    <form method="post" action="login.php">
        <table border="0" align="center" width="30%" cellpadding="2" cellspacing="5">

            <tr>
                <td class="pref">UserName</td>
                <td class="prefdisplaycentre"><input type="text" name="uname" size="12" maxlength="10"></td>
            </tr>
            <tr>
                <td class="pref">Password</td>
                <td class="prefdisplayecentre"><input type="password" name="pword" size="12" maxlength="10"></td>
            </tr>
            <tr>
                <td colspan="3" class="heading2" align="center">
                    <input type="submit" value="Login" name="Action">&nbsp;&nbsp;
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
    <?php
}
else
{
    include("connection.php");
    $conn = mysqli_connect($host,$uName,$pass,$dB)or die('Error connecting to MySQL server.');

    $query="SELECT admin_username FROM admin WHERE admin_username = ? AND admin_password = ?";

    $stmt = mysqli_prepare($conn, $query);

    $stmt->bind_param('ss', $uname, $pword);
    $uname = $_POST["uname"];
    $pword = hash('sha256', $_POST["pword"]);
    $stmt->execute();
    $stmt->bind_result($uname);

    if(!empty($stmt->fetch()))
    {
        $_SESSION["adminLogin"] = "success";
        header("location: home.php");

    }
    else
    {
        echo "Sorry, login details are incorrect";
        header("location: product.php");
    }
}
?>
</body>
</html>