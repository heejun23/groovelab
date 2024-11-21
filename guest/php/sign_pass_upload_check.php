<?php
  include("dbconn.php");
  
  $mb_no = $_SESSION['userno'];
  $mb_password = trim($_POST['mb_password']);

  $mb_pw = password_hash($mb_password, PASSWORD_DEFAULT);

  $sql = "UPDATE gl_member set mb_password = '$mb_pw' where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);
  if($result){
    echo "<script>alert('비밀번호가 변경되었습니다.');</script>";
    echo "<script>location.replace('../mypage.php');</script>";
  }else{
    die("비밀번호 변경 실패 : ".mysqli_error($conn));
  }
?>