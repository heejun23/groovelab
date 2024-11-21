<?php
  include('./dbconn.php');

  $mb_nick = trim($_POST['mb_nick']);

  if($mb_nick != NULL){
    $sql = "select * from gl_member where mb_nick = '$mb_nick'";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);

    if(isset($mb['mb_nick'])){
      echo "존재하는 닉네임입니다.";
    }else{
      echo "중복되지 않는 닉네임입니다.";
    }
  }else{
    echo "닉네임을 입력해 주세요.";
  }
?>