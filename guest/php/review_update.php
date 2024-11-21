<?php

include('dbconn.php');
$cm_no = $_GET['cm_no'];
$rv_star = $_POST['rv_star']; // 별점
$rv_content = $_POST['rv_content']; // 내용

date_default_timezone_set('Asia/Seoul');
$rv_datetime = date('Y-m-d H:i:s');


$mb_no = $_SESSION['userno'];

// 클래스등록한 학생의 클래스넘버 가져오기
$sql_c = "select * from gl_class_member where cm_no='$cm_no'";
$result_c = mysqli_query($conn, $sql_c);
$row_c = mysqli_fetch_array($result_c);
$cl_no = $row_c['cl_no'];

// 가져온 클래스넘버로 해당강의 카테고리, 썸네일, 제목찾기 
$sql = "select cl_category, cl_title, cl_thumbnail from gl_class where cl_no='$cl_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);



// 리뷰 업로드
$sql2 = "insert into gl_review set cm_no ='$cm_no',
cl_no = '$cl_no', mb_no = '$mb_no', rv_star = '$rv_star', rv_content = '$rv_content', 
rv_datetime = '$rv_datetime'";
$result2 = mysqli_query($conn, $sql2);

$point = "SELECT mb_point FROM gl_member WHERE mb_no = $mb_no";
$point_re = mysqli_query($conn, $point);
$po = mysqli_fetch_array($point_re);
$mb_point = $po['mb_point'];
$mb_point += 1000;

if($result2){
  $point2 = "UPDATE gl_member set mb_point='$mb_point' where mb_no='$mb_no'";
  $point2_re = mysqli_query($conn, $point2);
  echo "<script>alert('리뷰등록으로 1000포인트 적립되었습니다.');</script>";
  echo "<script>alert('평가가 등록되었습니다.');</script>";
  echo "<script>location.replace('../review_mypage.php');</script>";
  exit;
}else{
  echo "<script>alert('평가등록에 실패하였습니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}

?>


