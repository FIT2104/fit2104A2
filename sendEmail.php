<?php
session_start();
include "Authenticate.php";
ob_start();
include "menu.php";
include "connection.php";
?>

<html>
<head>
    <title>Famox Email Server</title>
</head>
<body>
<?php
if (!isset($_POST["check"]))
{
    ?>

    <?php
    $query="SELECT client_gname, client_fname, client_email FROM client WHERE client_mlist = 'Y' OR client_mlist = 'y' ORDER BY client_fname";
    $result = mysqli_query($conn, $query);
    ?>
    <center>
            <h1>Famox Email Server</h1>
        <p>
            <form method="post" action="sendEmail.php">
                <table border="1" cellpadding="4">
                    <tr>
                        <th bgcolor="#6495ed">Client</th>
                        <th bgcolor="#6495ed">Email?</th>
                    </tr>
                    <?php while ($clients= $result->fetch_assoc()) {?>
                    <tr>
                    <td><?php echo $clients["client_gname"]." ";
                        echo $clients["client_fname"];?>
                    </td>
                    <td>
                    <input type="checkbox" name="check[]" value="<?php echo $clients["client_email"]; ?>">
                    </td>
                    </tr>
        <?php } ?>
    </form>
    <form action="sendEmail.php" method="post">
        <table width="400" border="0" cellspacing="2" cellpadding="0">
            <tr>
                <td width="30%" class="bodytext">From :</td>
                <td width="70%">Harry.Helper@Famox.com.au</td>
            </tr>
            <tr>
                <td class="bodytext">Subject :</td>
                <td><input name="subject" type="text" id="email" size="32"></td>
            </tr>
            <tr>
                <td class="bodytext" align="top">Content :</td>
                <td><textarea name="content" cols="45" rows="6" id="comment" class="bodytext"></textarea></td>
            </tr>
            <tr>
                <td class="bodytext"> </td>
                <td align="left" valign="top">
                    <input type="Submit" name="Send" value="Send">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>

    <?php
}
else{
    $from = "From: Harry Helper <Harry.Helper@Famox.com.au>";
    $msg = $_POST["content"];
    $subject = $_POST["subject"];
    foreach($_POST["check[]"] as $to) {
        mail($to, $subject, $msg, $from);
    }
}
?>
</body>
</html>