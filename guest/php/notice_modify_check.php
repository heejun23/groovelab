<?php

include('dbconn.php');

$no_no = $_GET['no_no'];
$cl_no = $_POST['cl_no'];
$no_title = $_POST['no_title']; 
$no_content = $_POST['no_content']; 
date_default_timezone_set('Asia/Seoul');
$no_datetime = date("Y-m-d H:i:s");


$sql = "UPDATE gl_notice set
no_title = '$no_title',
no_content = '$no_content'
where no_no = $no_no";
$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('공지사항이 수정되었습니다.');</script>";
  echo "<script>location.replace('../notice.php?cl_no=".$cl_no."')</script>";
  exit;
}else{
  echo "<script>alert('공지사항 수정에 실패하였습니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}





?>