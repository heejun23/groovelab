
<?php
include('./dbconn.php');

$mb_no = $_POST['mb_no'];
$mb_nick = trim($_POST['mb_nick']);

if ($mb_nick != null) {
  // 중복 확인 쿼리 실행
  $sql = "SELECT * FROM gl_member WHERE mb_nick = '$mb_nick'";
  $result = mysqli_query($conn, $sql);

  //사용중이던 메일제외
  $sql = "SELECT mb_nick From gl_member WHERE mb_no = '$mb_no'";
  $result2 = mysqli_query($conn, $sql);
  $my_nick = mysqli_fetch_array($result2);

if($my_nick[0] == $mb_nick) { //내가 사용중이던 메일이라면 0
    echo "사용가능한 닉네임입니다.";
  } else if ($result->num_rows > 0) { //다른이가 사용중인 메일이라면 1
    echo "이미 사용중인 닉네임입니다. 다른 닉네임을 입력해주세요";
  } else {  // 아무도 사용하지 않은 메일이면 0
    echo "사용가능한 닉네임입니다.";
  }
} else {
  echo "닉네임을 입력해 주세요.";
}

?>


