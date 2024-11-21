<?php
include ("./dbconn.php");
$cart_no = $_GET["cart_no"];
$sql = "DELETE FROM gl_cart where cart_no = $cart_no";
$result = mysqli_query($conn, $sql);

echo "<script>alert('삭제되었습니다.');</script>";
echo "<script>location.replace('../cart.php');</script>";
?>