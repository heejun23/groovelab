<?php
include("./dbconn.php");
$no_no = $_GET['no_no'];

$sql = "delete from gl_notice where no_no = $no_no";
$result = mysqli_query($conn,$sql);

if($result){
  echo "<script>alert('삭제가 완료되었습니다.');</script>";
  echo "<script>location.replace('../notice_ad_list.php');</script>";
  exit;
}else{
  echo "입력실패 : ".mysqli_error($conn);
  mysqli_close($conn);
  exit;
}
?>