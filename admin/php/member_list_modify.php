<?php
include("./dbconn.php");

$mb_no = $_POST['mb_no'];
$mb_id = $_POST['mb_id'];
$mb_photo = trim($_POST['mb_photo']);
$mb_name = trim($_POST['mb_name']);
$mb_nick = trim($_POST['mb_nick']);
$mb_email = trim($_POST['mb_email']);
$mb_tel = trim($_POST['mb_tel']);
$mb_interest = isset($_POST['mb_interest']) ? implode(",", $_POST['mb_interest']) : "";
$mb_level = trim($_POST['mb_level']);



$ext = substr(strrchr($_FILES['sign_profile_photo']['name'], '.'), 1);

$mb_photo = $_FILES['sign_profile_photo']['name'] ?? "";
$hiddenPhoto = $_POST['profile_default'];
if (empty($mb_photo)) {
        $mb_photo = $hiddenPhoto;
} else {
        $mb_photo = $mb_id . "." . $ext;
        $upload_file_tmp = $_FILES['sign_profile_photo']['tmp_name'];
        $upload_folder = "../../guest/images/profile/";
        move_uploaded_file($upload_file_tmp, $upload_folder . $mb_photo);
}

// 업뎃쿼리
$sql = "UPDATE gl_member
        SET mb_photo = '$mb_photo',
            mb_name = '$mb_name',
            mb_nick = '$mb_nick',
            mb_email = '$mb_email',
            mb_tel = '$mb_tel',
            mb_interest = '$mb_interest',
            mb_level = '$mb_level'
        WHERE mb_no = '$mb_no';
";

// 쿼리실행
$result = mysqli_query($conn, $sql);

//성공여부 확인
if ($result) {
        if ($mb_level == 2) {
                echo "<script>
        alert('회원 정보수정이 완료되었습니다.');
        location.replace('../member_list_view_t.php?mb_no=" . $mb_no . "')
      </script>";
        }
        if ($mb_level == 1) {
                echo "<script>
                alert('회원 정보수정이 완료되었습니다.');
                location.replace('../member_list_view_s.php?mb_no=" . $mb_no . "')
              </script>";
        }
        exit;
} else {
        echo "<script>
          alert('회원 정보수정에 실패했습니다.');
        </script>";
        echo "에러 : " . mysqli_error($conn);
}
