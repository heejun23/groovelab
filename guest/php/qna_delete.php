<?php

include('dbconn.php');

$qna_no = $_GET['qna_no'];

$query = "select cl_no from gl_qna where qna_no = $qna_no";
$result2 = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result2);
$cl_no = $row['cl_no'];

$sql = "delete from gl_qna where qna_no='$qna_no' or qna_parent_no='$qna_no'";
$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('평가가 삭제되었습니다.')</script>";
  echo "<script>location.replace('../qna.php?cl_no=".$cl_no."');</script>";
  exit;
}else{
  echo "<script>alert('평가가 삭제되지 않았습니다.')</script>";
  echo "<script>history.back(1);</script>";
  exit;
}







?>