<?php
include("./dbconn.php");
//건네받은 정보
$no_title = $_POST['no_title'];
$mb_no = $_POST['mb_no'];
$cl_no = $_POST['cl_no'];
$no_content = $_POST['no_content'];
//작성시간
date_default_timezone_set('Asia/Seoul');
$no_datetime = date('Y-m-d H:i:s');

  echo $cl_no.'<br>';
  echo $mb_no.'<br>';
  echo $no_title.'<br>';
  echo $no_content.'<br>';
  echo $no_datetime.'<br>';

  $sql = "INSERT into gl_notice set
          cl_no = $cl_no,
          mb_no = $mb_no,
          no_title = '$no_title',
          no_content = '$no_content',
          no_datetime = '$no_datetime'";
  $result = mysqli_query($conn, $sql);
  
  if($result){
    echo "<script>alert('작성이 완료되었습니다.');</script>";
    echo "<script>location.replace('../notice_ad_list.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>