<?php
if(!(isset($_SESSION["adminLogin"])) AND ($_SESSION["adminLogin"] != "success")){
    header("location: login.php");
    exit();
}
?>