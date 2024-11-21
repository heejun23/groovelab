<?php
  include("./dbconn.php");

  $mb_no = $_POST["mb_no"];
  $mb_name = trim($_POST['mb_name']); //이름
  $mb_nick = trim($_POST['mb_nick']); //닉네임
  $mb_email = trim($_POST['mb_email']); //이메일
  $mb_tel = trim($_POST['mb_tel']) ?? ""; //전화번호
  $mb_interest = isset($_POST['mb_interest']) ? implode(",",$_POST['mb_interest']) : "";//관심클래스

  //프로필 사진
  // echo "<script>alert(".$_FILES[ 'sign_profile_photo' ][ 'name' ].");</script>";

  $mb_id = $_SESSION['userid'];

  $ext=substr(strrchr($_FILES['sign_profile_photo']['name'],'.'),1);

  $mb_photo = $_FILES['sign_profile_photo']['name'] ?? "";
  $hiddenPhoto = $_POST['profile_default'];
  if(empty($mb_photo)){
    $mb_photo = $hiddenPhoto;
  }else{
    $mb_photo = $mb_id.".".$ext;
    $upload_file_tmp = $_FILES['sign_profile_photo']['tmp_name'];
    $upload_folder = "../images/profile/";
    move_uploaded_file($upload_file_tmp, $upload_folder . $mb_photo);
  }


  $sql = "UPDATE gl_member set
          mb_photo = '$mb_photo',
          mb_name = '$mb_name',
          mb_nick = '$mb_nick',
          mb_email = '$mb_email',
          mb_tel = '$mb_tel',
          mb_interest = '$mb_interest'
          WHERE mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('수정이 완료되었습니다.');</script>";
    echo "<script>location.replace('../mypage.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>