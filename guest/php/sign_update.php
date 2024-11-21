<?php
  include("./dbconn.php");

  $mb_id = trim($_POST['mb_id']); //아이디  
  $mb_password = trim($_POST['mb_password']); //비밀번호
  $mb_name = trim($_POST['mb_name']); //이름
  $mb_nick = trim($_POST['mb_nick']); //닉네임
  $mb_email = trim($_POST['mb_email']); //이메일
  $mb_tel = trim($_POST['mb_tel']) ?? ""; //전화번호
  $mb_interest = isset($_POST['mb_interest']) ? implode(",",$_POST['mb_interest']) : "";//관심클래스

  //프로필 사진
  // echo "<script>alert(".$_FILES[ 'sign_profile_photo' ][ 'name' ].");</script>";


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

  //가입일자
  date_default_timezone_set('Asia/Seoul');
  $reg_date = date('Y-m-d H:i:s', time());

  //패스워드 해쉬화
  $mb_pw = password_hash($mb_password, PASSWORD_DEFAULT);


  $sql = "insert into gl_member set
          mb_photo = '$mb_photo',
          mb_id = '$mb_id',
          mb_password = '$mb_pw',
          mb_name = '$mb_name',
          mb_nick = '$mb_nick',
          mb_email = '$mb_email',
          mb_tel = '$mb_tel',
          mb_interest = '$mb_interest',
          mb_level = '1',
          mb_point = '0',
          reg_date = '$reg_date'";
  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<script>alert('가입이 완료되었습니다.');</script>";
    echo "<script>location.replace('../login.php');</script>";
    exit;
  }else{
    echo "입력실패 : ".mysqli_error($conn);
    mysqli_close($conn);
    exit;
  }
?>