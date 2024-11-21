<?php
include("./dbconn.php");

$mb_no = $_POST['mb_no'];
$cl_no= trim($_POST['cl_no']);


$sql = "SELECT progress
        FROM gl_class_member AS gcm
        INNER JOIN gl_member AS gm ON gm.mb_no = gcm.mb_no
        INNER JOIN gl_class AS gc ON gc.cl_no = gcm.cl_no
        WHERE gm.mb_no = '$mb_no'
        AND gcm.cl_no = '$cl_no'
";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
echo $row["progress"];

?>


