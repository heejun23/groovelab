<?php
include("./dbconn.php");
$rv_no = $_GET['rv_no'];

$sql = "DELETE FROM gl_review WHERE review_no = $rv_no";
$result = mysqli_query($conn,$sql);

if($result){
  echo "<script>alert('삭제가 완료되었습니다.');</script>";
  echo "<script>location.replace('../review_ad_list.php');</script>";
  exit;
}else{
  echo "삭제실패 : ".mysqli_error($conn);
  mysqli_close($conn);
  exit;
}
?>