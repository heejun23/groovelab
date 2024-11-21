<?php
include('./dbconn.php');

$mb_no = $_POST['mb_no'];
$mb_email = trim($_POST['mb_email']);

if ($mb_email != null) {
  // 중복 확인 쿼리 실행
  $sql = "SELECT * FROM gl_member WHERE mb_email = '$mb_email'";
  $result = mysqli_query($conn, $sql);

  //사용중이던 메일제외
  $sql = "SELECT mb_email From gl_member WHERE mb_no = '$mb_no'";
  $result2 = mysqli_query($conn, $sql);
  $my_email = mysqli_fetch_array($result2);

  // 이메일 유효성 검사
  $emailReg = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{3,4}$/";
  if(!preg_match($emailReg,$mb_email)){
    echo "유효한 이메일을 입력해주세요.";
  }else if
  // 결과 처리
($my_email[0] == $mb_email) { //내가 사용중이던 메일이라면 0
    echo "사용가능한 이메일입니다.";
  } else if ($result->num_rows > 0) { //다른이가 사용중인 메일이라면 1
    echo "이미 사용중인 이메일입니다. 다른 이메일을 입력해주세요";
  } else {  // 아무도 사용하지 않은 메일이면 0
    echo "사용가능한 이메일입니다.";
  }
} else {
  echo "이메일을 입력해 주세요.";
}

?>
