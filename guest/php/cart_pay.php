<?php
include ("./dbconn.php");
$mb_no = $_SESSION['userno'];

if (isset($_POST['select'])) {
  $i = 0;
  $point = 0;
  foreach ($_POST['select'] as $cart_no) {
    $sql = "select * from gl_cart where cart_no = $cart_no";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $cl_no = $row['cl_no'];
    date_default_timezone_set('Asia/Seoul');
    $cm_datetime = date('Y-m-d H:i:s');

    //시작과 끝 날짜 불러오기
    $sql = "select * from gl_class where cl_no = $cl_no";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    $startDate = $row['cl_start'];
    $endDate = $row['cl_end'];
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    // 두 날짜 사이의 차이를 구합니다.
    $interval = $endDate->diff($startDate);

    // 0부터 차이값 사이의 랜덤한 날짜를 생성합니다.
    $days = mt_rand(0, $interval->days);

    $randomDate = $startDate->add(new DateInterval("P{$days}D"));
    // 강의 시작날과 끝날 사이의 랜덤 날짜
    $randomDate = $randomDate->format('Y-m-d');

    $sql = "INSERT INTO `gl_class_member`(`cl_no`, `mb_no`, `progress`, `cm_datetime`, `cm_status`, `cm_randate`) VALUES ('$cl_no','$mb_no',0,'$cm_datetime',1,'$randomDate')";
    $result = mysqli_query($conn, $sql);
    $sql = "DELETE FROM gl_cart where cart_no = $cart_no";
    $result = mysqli_query($conn, $sql);
    
    $i++;
    $point+=2000;
  }
  //포인트 적립
  $mb_no = $_SESSION['userno'];
  $sql = "SELECT mb_point from gl_member where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $mb_point = $row[0];
  $mb_point += $point;
  $sql = "UPDATE gl_member set mb_point = $mb_point where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);

  echo "<script>alert('결제되었습니다.');</script>";
  echo "<script>alert('클래스 ".$i."개 결제로 ".$point."포인트 적립되었습니다.');</script>";
  echo "<script>location.replace('../mypage.php');</script>";

} else if (isset($_GET["cart_no"])) {
  $cart_no = $_GET["cart_no"];
  $sql = "select * from gl_cart where cart_no = $cart_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $cl_no = $row['cl_no'];
  date_default_timezone_set('Asia/Seoul');
  $cm_datetime = date('Y-m-d H:i:s');

  //시작과 끝 날짜 불러오기
  $sql = "select * from gl_class where cl_no = $cl_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $startDate = $row['cl_start'];
  $endDate = $row['cl_end'];
  $startDate = new DateTime($startDate);
  $endDate = new DateTime($endDate);

  // 두 날짜 사이의 차이를 구합니다.
  $interval = $endDate->diff($startDate);

  // 0부터 차이값 사이의 랜덤한 날짜를 생성합니다.
  $days = mt_rand(0, $interval->days);

  $randomDate = $startDate->add(new DateInterval("P{$days}D"));
  // 강의 시작날과 끝날 사이의 랜덤 날짜
  $randomDate = $randomDate->format('Y-m-d');

  $sql = "INSERT INTO `gl_class_member`(`cl_no`, `mb_no`, `progress`, `cm_datetime`, `cm_status`, `cm_randate`) VALUES ('$cl_no','$mb_no',0,'$cm_datetime',1,'$randomDate')";
  $result = mysqli_query($conn, $sql);
  $sql = "DELETE FROM gl_cart where cart_no = $cart_no";
  $result = mysqli_query($conn, $sql);

  //포인트 적립
  $mb_no = $_SESSION['userno'];
  $sql = "SELECT mb_point from gl_member where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $point = $row[0];
  $point += 2000;
  $sql = "UPDATE gl_member set mb_point = $point where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);

  echo "<script>alert('결제되었습니다.');</script>";
  echo "<script>alert('클래스 1개 결제로 2000포인트 적립되었습니다.');</script>";
  echo "<script>location.replace('../mypage.php');</script>";
}
?>