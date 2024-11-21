<?php

include ('dbconn.php');

$cl_no = $_GET['cl_no'];

$sql = "SELECT * from gl_class_member WHERE cl_no = $cl_no and cm_status != 3";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if (isset($row[0])) {
  echo "<script>alert('수강중인 학생이 있어 삭제할 수 없습니다.')</script>";
  echo "<script>history.back(1);</script>";
  exit;
} else {
  $sql = "delete from gl_class where cl_no='$cl_no'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<script>alert('클래스가 삭제되었습니다.')</script>";
    echo "<script>history.back(1);</script>";
    exit;
  } else {
    echo "<script>alert('클래스가 삭제되지 않았습니다.')</script>";
    echo "<script>history.back(1);</script>";
    exit;
  }
}


?>