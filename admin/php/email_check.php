<?php
  include('./dbconn.php');

  $mb_no = $_POST['mb_no'];
  $mb_email = trim($_POST['mb_email']);

// 중복 확인 쿼리 실행
$sql = "SELECT * FROM gl_member WHERE mb_email = '$mb_email'";
$result = mysqli_query($conn, $sql);

//사용중이던 메일제외
$sql = "SELECT mb_email From gl_member WHERE mb_no = '$mb_no'";
$result2 = mysqli_query($conn, $sql);
$my_email = mysqli_fetch_array($result2);


// 결과 처리
if ($my_email[0] == $mb_email) { //내가 사용중이던 메일이라면 0
  echo trim("0");
} else if ($result->num_rows > 0) { //다른이가 사용중인 메일이라면 1
  echo trim("1");
} else {  // 아무도 사용하지 않은 메일이면 0
  echo trim("0");
}
?>