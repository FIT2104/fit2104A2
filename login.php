<?php
session_start();
ob_start();

/**
 * Created by PhpStorm.
 * User: Timothy
 **/
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
    <form method="post" action="login.php" name="loginform">
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
    if (isset($_SESSION['badlogin'])){
        if($_SESSION['badlogin'] == "true") {
            ?>
        <td width = '80' style='text-align:center;'>
        <?php echo "Opps, Invalid login information."; ?>
        </td>
<?php
        }
    }
}
else
{
    include("connection.php");
    //$conn = mysqli_connect($host,$uName,$pass,$dB)or die('Error connecting to MySQL server.');

    $query="SELECT admin_id FROM admin WHERE admin_username = ? AND admin_password = ?";

    $stmt = mysqli_prepare($conn, $query);
    //$stmt->execute();

    $stmt->bind_param('ss', $uname, $pword);
    $uname = $_POST["uname"];
    $pword = hash('sha256', $_POST["pword"]);
    $stmt->execute();
    $stmt->bind_result($uname);

    if(!empty($stmt->fetch())) {
        $_SESSION["adminLogin"] = "success";
        $_SESSION["badlogin"] = "false";
        header("location: home.php");

    }
    else
    {
        $_SESSION["badlogin"] = "true";
        header("location: login.php");
    }
}
?>
</body>
</html>
