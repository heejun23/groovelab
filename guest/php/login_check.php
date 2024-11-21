<?php
include ("dbconn.php");

// 아이디 비밀번호 POST로 넘겨받기
$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

// echo $mb_id . '<br>';
// echo $mb_password;

$sql = "select * from gl_member where mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);

$mb_pw = $row[2];

if (password_verify($mb_password, $mb_pw)) {
  if ($row[9] == 3) {
    echo "<script>alert('관리자 페이지에서 로그인해주세요.');</script>";
    echo "<script>history.back();</script>";
    exit;
  }

  //출석체크 포인트 적립
  $mb_no = $row[0];
  $sql = "SELECT at_no from gl_attend where at_date = CURDATE() AND mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);
  $point_row = mysqli_fetch_row($result);
  if (!isset($point_row[0]) && $row[9] == 1) {
    $point = $row[10];
    $point += 100;
    $sql = "UPDATE gl_member set mb_point = $point where mb_no = $mb_no";
    $result = mysqli_query($conn, $sql);
    $sql = "INSERT into gl_attend set mb_no = $mb_no, at_date = CURDATE()";
    $result = mysqli_query($conn, $sql);
    echo "<script>alert('출석체크로 100포인트 적립되었습니다.');</script>";
  }

  $_SESSION['userid'] = $row[1];
  $_SESSION['userlevel'] = $row[9];
  $_SESSION['usernick'] = $row[5];
  $_SESSION['userno'] = $row[0];
  $_SESSION['userphoto'] = $row[3];
  echo "<script>alert('그루브랩에 오신것을 환영합니다. " . $row['5'] . "님');</script>";
  echo "<script>location.replace('../index.php');</script>";
  exit;

} else {
  echo "<script>alert('아이디나 비밀번호가 정확한지 확인해주세요');</script>";
  echo "<script>history.back();</script>";
}

?>