<?php
// class_ad_update 강의등록 폼에서 넘겨받기

include ("dbconn.php");

// 강의 동영상
$uploads_dir = '../images/video/';

if ($_FILES['cl_video']['size'] > 0) { // 업로드 파일 사이즈를 체크하여, 업로드 파일 여부를 확인

  $files = $_FILES['cl_video'];
  $filename = $files['name'];

  $tmpName = $files['tmp_name'];

  move_uploaded_file($tmpName, $uploads_dir . "/" . $filename);
}

//썸네일
if ($_FILES['cl_thumbnail']['name']) {
  $upload_folder = "../images/class/";
  $ext_chk = array("jpg", "jpeg", "png", "gif");

  $uploaded_file_name_tmp = $_FILES['cl_thumbnail']['tmp_name'];
  ;
  $uploaded_file_name = $_FILES['cl_thumbnail']['name'];
  $ext = explode(".", $uploaded_file_name);
  $file_ext = array_pop($ext);

  if (!in_array($file_ext, $ext_chk)) {
    echo "<script>alert('허용되지 않는 파일형식입니다.');</script>";
    echo "<script>history.back();</script>";
    exit;
  }

  move_uploaded_file($uploaded_file_name_tmp, $upload_folder . "/" . $uploaded_file_name);
}

// 디테일 이미지
if ($_FILES['cl_desc_image']['name']) {
  $upload_folder2 = "../images/detail_img/";
  $ext_chk2 = array("jpg", "jpeg", "png", "gif");

  $uploaded_file_name_tmp2 = $_FILES['cl_desc_image']['tmp_name'];
  ;
  $uploaded_file_name2 = $_FILES['cl_desc_image']['name'];
  $ext2 = explode(".", $uploaded_file_name2);
  $file_ext2 = array_pop($ext2);

  if (!in_array($file_ext2, $ext_chk2)) {
    echo "<script>alert('허용되지 않는 파일형식입니다.');</script>";
    echo "<script>history.back();</script>";
    exit;
  }

  move_uploaded_file($uploaded_file_name_tmp2, $upload_folder2 . "/" . $uploaded_file_name2);
}


$cl_category = $_POST['cl_category']; //클래스 카테고리
$cl_teacher = $_POST['cl_teacher']; //강사명
$cl_title = trim($_POST['cl_title']); //강의명
$cl_price = trim($_POST['cl_price']);//강의가격
$cl_time = trim($_POST['cl_time']);//강의시간
$cl_start = trim($_POST['cl_start']);//시작일
$cl_end = trim($_POST['cl_end']);//종료일
$cl_desc = trim($_POST['cl_desc']);//강의소개
$cl_thumbnail = $_FILES['cl_thumbnail']['name']; //썸네일
$cl_desc_image = $_FILES['cl_desc_image']['name'];  // 상세페이지
$cl_video = $_FILES['cl_video']['name']; //강의비디오

if (empty($cl_thumbnail && $cl_title && $cl_price && $cl_time && $cl_start && $cl_end && $cl_desc)) {
  echo "<script>alert('공백이 있으면 안됩니다.');</script>";
  echo "<script>history.back();</script>";
  exit;
}

// echo "클래스 카테고리 : $cl_category <br>";
// echo "강사명 : $cl_teacher <br>";
// echo "강의명 : $cl_title <br>";
// echo  "강의가격 : " .number_format($cl_price)."원 <br>";
// echo "강의시간 : $cl_time 분 <br>";
// echo "시작일 : $cl_start <br>";
// echo "종료일 : $cl_end <br>";
// echo "강의영상 : <video src='../images/video/".htmlspecialchars($cl_video)."'></video> <br>";
// echo "이미지파일 : <img src='../images/class/".htmlspecialchars($cl_thumbnail)."'> <br>";
// echo "디테일이미지 : <img src='../images/detail_img/".htmlspecialchars($cl_desc_image)."'> <br>";
// echo "강의소개 : $cl_desc <br>";


$sql = "select * from gl_member where mb_nick = '$cl_teacher'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_no = $row['mb_no'];


$sql = "insert into gl_class set
mb_no ='$mb_no',
cl_category = '$cl_category',
cl_title = '$cl_title',
cl_teacher = '$cl_teacher',
cl_price = '$cl_price',
cl_time = '$cl_time',
cl_thumbnail = '$cl_thumbnail',
cl_start = '$cl_start',
cl_end = '$cl_end',
cl_desc = '$cl_desc',
cl_desc_image = '$cl_desc_image',
cl_video = '$cl_video'";
$result = mysqli_query($conn, $sql);


// 챕터 넣기
//cl_no 가져오기
$query = "SELECT cl_no from gl_class where 
mb_no ='$mb_no' and
cl_category = '$cl_category' and
cl_title = '$cl_title' and
cl_teacher = '$cl_teacher' and
cl_price = '$cl_price' and
cl_time = '$cl_time' and
cl_thumbnail = '$cl_thumbnail' and
cl_start = '$cl_start' and
cl_end = '$cl_end' and
cl_desc = '$cl_desc' and
cl_desc_image = '$cl_desc_image' and
cl_video = '$cl_video'";
$result_cl = mysqli_query($conn, $query);
$cl_row = mysqli_fetch_array($result_cl);
$cl_no = $cl_row['cl_no'];

// 제목과 설명 가져오기
$cc_titles = $_POST['cc_title'];
$cc_descs = $_POST['cc_desc'];

// 비디오 파일 정보 가져오기
$cc_videos = $_FILES['cc_video'];

//데이터의 길이 구하기
$cc_length = count($cc_titles);
for ($i = 0; $i < $cc_length; $i++) {
  $no = $i+1;
  $cc_title = $cc_titles[$i];
  $cc_desc = $cc_descs[$i];    
  $cc_video = $cc_videos['name'][$i]; // 수정: 다차원 배열 접근
  $cc_tmp_name = $cc_videos['tmp_name'][$i]; // 수정: 다차원 배열 접근
  $uploads_dir = '../images/chapter_video/';
  $filename = $cc_video;
  $tmpName = $cc_tmp_name;
  move_uploaded_file($tmpName, $uploads_dir . "/" . $filename);

  // echo $cc_title."<br>";
  // echo $cc_desc."<br>";
  // echo $cc_video."<br>";

  $query = "INSERT into gl_class_chapter ( `cl_no`, `cc_chapter_no`, `cc_title`, `cc_video`, `cc_desc`) VALUES ('$cl_no','$no','$cc_title','$cc_video','$cc_desc')";
  $cc_result = mysqli_query($conn, $query);
}

if($result){
    echo "<script>alert('강의가 정상적으로 등록되었습니다.');</script>";
    echo "<script>location.replace('../class_ad_list.php');</script>";
    exit;
}else{
    echo "<script>alert('강의등록에 실패하였습니다.');</script>";
    echo "<script>history.back();</script>";
    exit;
}

?>