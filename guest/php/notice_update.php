<?php

include('dbconn.php');

$cl_no = $_GET['cl_no'];
$no_title = $_POST['no_title']; // qna 제목
$no_content = $_POST['no_content']; // qna 내용
date_default_timezone_set('Asia/Seoul');
$no_datetime = date("Y-m-d H:i:s");

$mb_no = $_SESSION['userno'];
$sql = "select * from gl_member where mb_no";
$result = mysqli_query($conn, $sql);

$sql2 = "insert into gl_notice set
cl_no = '$cl_no',
mb_no ='$mb_no',
no_title = '$no_title',
no_content = '$no_content',
no_datetime = '$no_datetime'";
$result2 = mysqli_query($conn, $sql2);

if($result2){
  echo "<script>alert('공지사항이 등록되었습니다.');</script>";
  echo "<script>location.replace('../notice.php?cl_no=".$cl_no."');</script>";
  exit;
}else{
  echo "<script>alert('공지사항 등록에 실패하였습니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}

?>