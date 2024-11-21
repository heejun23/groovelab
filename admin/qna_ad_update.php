<?php
  include("./dbconn.php");

  $cl_no = $_POST['cl_no'];
  $mb_no = $_SESSION['userno'];
  $qna_parent_no = $_POST['qna_no'];
  $qna_title = $_POST['qna_title'];
  $qna_content = $_POST['qna_reply'];

  date_default_timezone_set('Asia/Seoul');
  $qna_datetime = date('Y-m-d H:i:s');

  $sql = "INSERT into gl_qna set
          cl_no = $cl_no,
          mb_no = $mb_no,
          qna_parent_no = $qna_parent_no,
          qna_title = '$qna_title',
          qna_content = '$qna_content',
          qna_datetime = '$qna_datetime'";
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('작성이 완료되었습니다.');</script>";
    echo "<script>location.replace('../qna_ad_list.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>