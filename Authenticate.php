<?php
if($_SESSION["adminLogin"] != "success"){
    ?>
    <script type='text/javascript'>
        alert('Please login before visiting this page');
        window.location = 'login.php?Action=Show';
    </script>;
<?php
    exit();
}
?>