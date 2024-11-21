<?php
  include('./dbconn.php');

  $mb_email = trim($_POST['mb_email']);

  if($mb_email != NULL){
    $sql = "select * from gl_member where mb_email = '$mb_email'";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);

    if(isset($mb['mb_email'])){
      echo "존재하는 이메일입니다.";
    }else{
      echo "중복되지 않는 이메일입니다.";
    }
  }else{
    echo "이메일을 입력해 주세요.";
  }
?>