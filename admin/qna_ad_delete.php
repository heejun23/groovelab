<?php
include("./dbconn.php");
$qna_no = $_GET['qna_no'];

$sql = "DELETE FROM gl_qna WHERE qna_no = $qna_no OR qna_parent_no = $qna_no";
$result = mysqli_query($conn,$sql);

if($result){
  echo "<script>alert('삭제가 완료되었습니다.');</script>";
  echo "<script>location.replace('../qna_ad_list.php');</script>";
  exit;
}else{
  echo "입력실패 : ".mysqli_error($conn);
  mysqli_close($conn);
  exit;
}
?>