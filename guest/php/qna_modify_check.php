<?php

include('dbconn.php');

$qna_no = $_GET['qna_no'];
$cl_no = $_POST['cl_no'];
//qna 사진첨부

if ($_FILES['qna_image']['name']) {
  $upload_folder = "../images/qna/";
  $ext_chk = array("jpg", "jpeg", "png", "gif");

  $uploaded_file_name_tmp = $_FILES[ 'qna_image' ][ 'tmp_name' ];;
  $uploaded_file_name = $_FILES[ 'qna_image' ][ 'name' ];
  $ext = explode(".", $uploaded_file_name);
  $file_ext = array_pop($ext);

  if( !in_array($file_ext ,$ext_chk)){
      echo "<script>alert('허용되지 않는 파일형식입니다.');</script>";
      echo "<script>history.back();</script>";
      exit;
  }

  move_uploaded_file( $uploaded_file_name_tmp, $upload_folder ."/". $uploaded_file_name );
}


$mb_nick = $_POST['mb_nick']; // qna 제목
$qna_title = $_POST['qna_title']; // qna 제목
$qna_content = $_POST['qna_content']; // qna 내용
$qna_image = $_FILES[ 'qna_image' ][ 'name' ];  // qna 사진첨부
date_default_timezone_set('Asia/Seoul');
$qna_datetime = date("Y-m-d H:i:s");


$mb_no = $_SESSION['userno'];
$sql = "select * from gl_member where mb_no='$mb_no'";
$result = mysqli_query($conn, $sql);


$sql2 = "update gl_qna set
cl_no = '$cl_no',
mb_no ='$mb_no',
qna_title = '$qna_title',
qna_content = '$qna_content',
qna_datetime = '$qna_datetime',
qna_image = '$qna_image' where qna_no='$qna_no'";
$result2 = mysqli_query($conn, $sql2);

if($result2){
  echo "<script>alert('질문이 수정되었습니다.');</script>";
  echo "<script>location.replace('../qna.php?cl_no=".$cl_no."');</script>";
  exit;
}else{
  echo "<script>alert('질문수정에 실패하였습니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}

?>