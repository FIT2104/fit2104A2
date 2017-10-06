<?php
session_start();
include "menu.php";

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
unset($_SESSION['adminLogin']);
unset($_SESSION['badLogin']);
$strAction = $_GET["Action"];

switch ($strAction) {
    case "Show": { ?>

        <form method="post" action="login.php?Action=signIn" name="loginForm">

            <table border="0" align="center" width="30%" cellpadding="2" cellspacing="5">

                <tr>
                    <td class="pref">User Name</td>
                    <td class="prefdisplaycentre"><input type="text" name="uname" size="12" maxlength="10"></td>
                </tr>
                <tr>
                    <td class="pref">Password</td>
                    <td class="prefdisplayecentre"><input type="password" name="pword" size="12" maxlength="10"></td>
                </tr>
                <tr>
                    <td colspan="3" class="heading2" align="center">
                        <input type="submit" value="Login">&nbsp;&nbsp;
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        break;
    }
    case "signIn" : {

        $query = "SELECT admin_id FROM admin WHERE admin_username = ? AND admin_password = ?";

        $stmt = mysqli_prepare($conn, $query);
        //$stmt->execute();

        $stmt->bind_param('ss', $uname, $pword);
        $uname = $_POST["uname"];
        $pword = hash('sha256', $_POST["pword"]);
        $stmt->execute();
        $stmt->bind_result($uname, $pword);

        if (!empty($stmt->fetch())) {

            $_SESSION["adminLogin"] = "success";
            $_SESSION['username'] = $uname;
            ?>
<script type='text/javascript'>
    alert('Login successfully');
        window.location = 'home.php';
    </script>;
<?php
        } else {
            $_SESSION["adminLogin"] = "false";
    ?>
    <script type='text/javascript'>
        alert('Oops, Invalid Login Information');
        window.location = 'login.php?Action=Show';
    </script>;
    <?php
        }
    }
}
?>
</body>
</html>
