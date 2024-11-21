<?php
  include("dbconn.php");

  $qna_parent_no = $_GET['qna_no'];
  $qna_content = $_POST['qna_reply'];

  date_default_timezone_set('Asia/Seoul');
  $qna_datetime = date('Y-m-d H:i:s');

  $sql = "select qna_title, cl_no, mb_no from gl_qna where qna_no='$qna_parent_no'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $qna_title = $row['qna_title'];
  $cl_no = $row['cl_no'];
  $mb_no = $_SESSION['userno'];

  $sql = "INSERT into gl_qna set
          cl_no = '$cl_no',
          mb_no = '$mb_no',
          qna_title = '$qna_title',
          qna_parent_no = '$qna_parent_no',
          qna_content = '$qna_content',
          qna_datetime = '$qna_datetime'";
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('답변이 등록되었습니다.');</script>";
    echo "<script>location.replace('../qna.php?cl_no=".$cl_no."');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>