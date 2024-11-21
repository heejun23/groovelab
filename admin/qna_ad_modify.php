<?php
  include("./dbconn.php");

  $qna_content = $_POST['qna_reply'];
  $qna_answer_no = $_POST['qna_answer_no'];

  $sql = "UPDATE gl_qna set
          qna_content = '$qna_content'
          where qna_no = $qna_answer_no";
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('수정이 완료되었습니다.');</script>";
    echo "<script>location.replace('../qna_ad_list.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>