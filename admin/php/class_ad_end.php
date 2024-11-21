<?php
  include("./dbconn.php");

  $cl_no = $_GET['cl_no'];

  $query = "UPDATE gl_class_member set cm_status = 2 where cl_no = $cl_no";
  $result = mysqli_query($conn, $query);

  if($result){
    echo "<script>alert('클래스 종료 처리되었습니다.');</script>";
    echo "<script>history.back(-1);</script>";
    exit;
  }else{
    echo "<script>alert('클래스 종료 실패하였습니다.');</script>";
    die("처리 실패 : ".mysqli_error($conn));
    mysqli_close($conn);
  }
?>