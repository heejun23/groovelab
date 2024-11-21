<?php
include("./php/dbconn.php");
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : <?= $title ?></title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- class_mypage_view.css -->
  <link rel="stylesheet" href="./css/class_mypage_view.css" type="text/css">
  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
  <?php
  $mb_level = $_SESSION['userlevel'];
  $mb_no = $_SESSION['userno'];
  $cl_no = $_GET['cl_no'];
  if ($mb_level == '2') {
    //만약 내 강의가 아니면 마이페이지로 돌아간다.
    $query = "SELECT count(*) from gl_class where mb_no = '$mb_no' AND cl_no = '$cl_no'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $isMine = $row[0];

    if ($isMine == "0") {
      echo "<script>alert('내 강의가 아닙니다.');</script>";
      echo "<script>location.replace('./mypage.php');</script>";
      exit;
    }

    $title = "진행중인 클래스";
  } else if ($mb_level == '1') {
    //만약 내 강의가 아니면 마이페이지로 돌아간다.
    $query = "SELECT count(*) from gl_class_member where mb_no = '$mb_no' AND cl_no = '$cl_no'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $isMine = $row[0];

    if ($isMine == "0") {
      echo "<script>alert('내 강의가 아닙니다.');</script>";
      echo "<script>location.replace('./mypage.php');</script>";
      exit;
    }

    $title = "수강중인 클래스";
  } else {
    echo "<script>alert('잘못된 접근입니다.');</script>;";
    echo "<script>location.replace('./index.php');</script>";
    exit;
  }

  $sql = "SELECT * from gl_class where cl_no = $cl_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  ?>
  <div class="mobile_wrap">
    <?php include('./header_m.php') ?>
    <nav id="head">
      <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
      <p><?= $title ?></p>
    </nav>
    <main>
      <div class="class_mypage_info">
        <div class="class_mypage_info_thumb">
          <img src="../admin/images/class/<?= $row['cl_thumbnail'] ?>" alt="클래스썸네일">
        </div>
        <div class="class_mypage_info_text">
          <h2><?= $row['cl_title'] ?></h2>
          <p>크리에이터 : <?= $row['cl_teacher'] ?></p>
          <p>클래스 시작일 : <?= $row['cl_start'] ?></p>
          <p>클래스 종료일 : <?= $row['cl_end'] ?></p>
          <p class="class_desc"><?= $row['cl_desc'] ?></p>
        </div>
      </div>

      <div class="class_mypage_tables">
        <a href="./notice.php?cl_no=<?= $cl_no ?>"><img src="./images/notice_white.svg" alt="공지사항">공지사항</a>
        <a href="./qna.php?cl_no=<?= $cl_no ?>"><img src="./images/q&a_white.svg" alt="QNA">QNA</a>
      </div>

      <div class="class_mypage_list">
        <div>목차</div>
        <ul>
          <?php
          $cl_no = $_GET['cl_no'];
          $sql = "SELECT * from gl_class_chapter where cl_no ='$cl_no' order by cc_chapter_no asc";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_array($result)):
          ?>
            <li>
              <a href="./class_classroom.php?cl_no=<?= $row['cl_no'] ?>&chapter_no=<?= $row['cc_chapter_no'] ?>">
                <div class="class_chapter_no"><?= $row['cc_chapter_no'] ?>강</div>
                <div class="class_chapter_title"><?= $row['cc_title'] ?></div>
                <img src="./images/video_play_white.svg" alt="클래스듣기">
              </a>
            </li>
          <?php endwhile ?>
        </ul>
      </div>
    </main>

    <?php include('./bottom_gnb.php') ?>
  </div>

  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</body>

</html>