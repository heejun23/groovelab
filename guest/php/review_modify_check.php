<?php

include('dbconn.php');

$review_no = $_GET['review_no'];
$rv_star = $_POST['rv_star']; // 별점
$rv_content = $_POST['rv_content']; // 내용
date_default_timezone_set('Asia/Seoul');
$rv_datetime = date('Y-m-d H:i:s');

$sql = "UPDATE gl_review set
rv_star = '$rv_star',
rv_content = '$rv_content'
where review_no = $review_no";
$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('평가가 정상적으로 수정되었습니다.');</script>";
  echo "<script>location.replace('../review_mypage.php')</script>";
  exit;
}else{
  echo "<script>alert('평가 수정에 실패하였습니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}





?>