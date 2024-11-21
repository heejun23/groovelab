<?php
  include('./dbconn.php');

  $mb_id = trim($_POST['mb_id']);

  if($mb_id != NULL){
    $sql = "select * from gl_member where mb_id = '$mb_id'";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);

    if(isset($mb['mb_id'])){
      echo "존재하는 아이디입니다.";
    }else{
      echo "중복되지 않는 아이디입니다.";
    }
  }else{
    echo "아이디를 입력해 주세요.";
  }
?>