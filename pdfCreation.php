<?php
ob_start();
require "vendor/autoload.php";
include "connection.php";
include "CreatePDF.php";
?>

<html>
<head>
    <title>Famox Client PDF</title>
</head>
<body>
    <h1>Famox Client List</h1>
    <?php
    $conn = new mysqli($host,$uName,$pass,$dB);

    $query = "SELECT * FROM client ORDER BY client_fname";
    $result = mysqli_query($conn, $query);
    $allRows = mysqli_fetch_all($result, MYSQL_ASSOC);

    $header = array('Client ID', 'Given Name', 'Family Name', 'Email', 'Phone', 'Mobile', 'Mailing', 'Street', 'Suburb', 'State', 'Postcode');
    $headerWidth = array(150, 250, 250, 300, 250, 250, 100, 300, 300, 200, 200);
    $pdf = new CreatePDF();

    $table = $PDF->ClientPDF($header, $headerWidth, $allRows);

    echo $table;
    echo "<br />";
    echo "<a href='PDFS/Client.pdf'>Click here to see PDF</a>";

    ?>
</body>
</html>
