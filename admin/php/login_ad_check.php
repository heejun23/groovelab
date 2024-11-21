<?php
  include('dbconn.php');

  $mb_id = trim($_POST['mb_id']);
  $mb_password = trim($_POST['mb_password']);

  // echo $mb_id;
  // echo $mb_password;

  if(!$mb_id || !$mb_password){
    echo "<script>alert('아이디가 공백이거나 비밀번호가 다릅니다.');</script>";
    echo "<script>history.back()</script>";
    exit;
  }

  $mb_pw = password_hash($mb_password, PASSWORD_DEFAULT);

  $sql = "select * from gl_member where mb_id='$mb_id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_row($result);

  $mb_pw = $row[2];

  if(password_verify($mb_password, $mb_pw)){
    $_SESSION['userid'] = $row[1];
    $_SESSION['usernikname'] = $row[5];
    $_SESSION['userno'] = $row[0];
    if($row[9] == 3){
      echo"<script>alert('관리자 페이지로 로그인되었습니다.')</script>";
      echo"<script>location.replace('../mypage_ad.php')</script>";
      exit;
    }
    if($row[9] == 2){
      echo"<script>alert('강사님 페이지로 로그인되었습니다.')</script>";
      echo"<script>location.replace('../mypage_t.php')</script>";
      exit;
    }
    if($row[9] == 1){
      echo"<script>alert('일반회원은 접근할 수 없습니다.')</script>";
      echo"<script>history.back()</script>";
      exit;
    }
  }else{
    echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.');</script>";
    echo "<script>location.replace('../login_ad.php');</script>";
    exit;
  }




?>