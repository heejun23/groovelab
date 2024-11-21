<?php
include("./dbconn.php");
//건네받은 정보
$no_title = $_POST['no_title'];
$no_content = $_POST['no_content'];
$no_no = $_POST['no_no'];

  echo $no_title.'<br>';
  echo $no_content.'<br>';

  $sql = "UPDATE gl_notice set
          no_title = '$no_title',
          no_content = '$no_content'
          where no_no = $no_no";
  $result = mysqli_query($conn, $sql);
  
  if($result){
    echo "<script>alert('수정이 완료되었습니다.');</script>";
    echo "<script>location.replace('../notice_ad_list.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>