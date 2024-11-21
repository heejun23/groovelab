<?php
include('dbconn.php');

$mb_no = $_SESSION['userno'];

$mb_email = trim($_POST['mb_email']);
$mb_password = trim($_POST['mb_password']);

$sql = "select * from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if($row['mb_email'] != $mb_email || !password_verify($mb_password, $row['mb_password'])){
  echo "<script>alert('이메일과 비밀번호가 정확한지 확인해주세요.');</script>";
  echo "<script>history.back();</script>";
  exit;
}else{
  echo "<script>location.replace('../sign_upload.php');</script>";
  exit;
}
?>
