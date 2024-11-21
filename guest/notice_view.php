<?php
// login.php
include('./php/dbconn.php');

$no_no = $_GET['no_no'];

$sql = "select * from gl_notice where no_no='$no_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 공지사항</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- notice_view.css -->
  <link rel="stylesheet" href="./css/notice_view.css" type="text/css">

</head>

<body>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php'); ?>
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>공지사항</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="qna_view">
      <h2 class="blind">공지사항</h2>
      <!-- 제목 프로필 박스 -->
      <div class="qna_view_head">
        <p class="qna_view_title"><?php echo $row['no_title'] ?></p>
        <p class="qna_view_date"><?php echo substr($row['no_datetime'], 0, 10) ?></p>

        <?php
        $mb_no = $row['mb_no'];
        $sql2 = "select mb_photo, mb_nick, mb_level from gl_member where mb_no = '$mb_no'";
        $result2 = mysqli_query($conn, $sql2);
        $mb = mysqli_fetch_assoc($result2);
        ?>
        <div class="qna_view_profile_box">
          <div class="qna_view_profile">
            <img src="./images/profile/<?= $mb['mb_photo'] ?>">
          </div>
          <p class="qna_view_usernick"><?php echo $mb['mb_nick'] ?></p>
        </div>
      </div>

      <!-- 사진 글내용 박스 -->
      <div class="qna_view_img_txt">
        <p class="qna_view_body_txt">
          <?php echo $row['no_content'] ?>
        </p>
      </div>

      <?php
      $sql3 = "select mb_no from gl_notice where no_no='$no_no'";
      $result3 = mysqli_query($conn, $sql3);
      $my_account = mysqli_fetch_array($result3);
      if ($_SESSION['userlevel'] == 2 && $mb_no = $_SESSION['userno'] == $my_account['mb_no']) { ?>
        <!-- 삭제/수정 버튼 -->
        <div class="qna_view_btn">
          <a href="./php/notice_delete.php?no_no=<?php echo $row['no_no'] ?>" id="qna_view_del"><img src="./images/delete_white.svg" alt="삭제">삭제</a>
          <a href="notice_modify.php?no_no=<?php echo $row['no_no'] ?>" id="qna_view_edit"><img src="./images/edit_black.svg" alt="수정">수정</a>
        </div>
      <?php } ?>
    </section>
  </main>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>

</body>

</html>