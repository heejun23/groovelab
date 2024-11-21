<?php

include('dbconn.php');

$no_no = $_GET['no_no'];

$query = "select cl_no from gl_notice where no_no = $no_no";
$result2 = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result2);
$cl_no = $row['cl_no'];


$sql = "delete from gl_notice where no_no='$no_no'";
$result = mysqli_query($conn, $sql);

if($result){
  echo "<script>alert('공지글이 삭제되었습니다.')</script>";
  echo "<script>location.replace('../notice.php?cl_no=".$cl_no."');</script>";
  exit;
}else{
  echo "<script>alert('공지글이 삭제되지 않았습니다.')</script>";
  echo "<script>history.back(1);</script>";
  exit;
}







?>