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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <link rel="stylesheet" href="./css/class_classroom.css" type="text/css">
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

    $title = "나의 강의실";
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

    $title = "나의 클래스 룸";
  } else {
    echo "<script>alert('잘못된 접근입니다.');</script>;";
    echo "<script>location.replave('./index.php');</script>";
    exit;
  }

  $cl_no = $_GET['cl_no'];
  $chapter_no = $_GET['chapter_no'];
  $sql = "SELECT * from gl_class_chapter where cl_no = $cl_no and cc_chapter_no = $chapter_no";
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
      <div class="class_classroom_cont">
        <video src="../admin/images/chapter_video/<?= $row['cc_video'] ?>" controls></video>
        <div class="info">
          <h3><?= $row['cc_chapter_no'] ?>강. <?= $row['cc_title'] ?></h3>
          <p><?= $row['cc_desc'] ?></p>
        </div>
      </div>

      <input type="checkbox" name="class_mypage_check" id="class_mypage_check">
      <div class="class_mypage_list">
        <label for="class_mypage_check">목차<img src="./images/arrow_down_white.svg" alt="목록보기"></label>
        <ul>
          <?php
          $cl_no = $_GET['cl_no'];
          $sql = "SELECT * from gl_class_chapter where cl_no ='$cl_no' order by cc_chapter_no asc";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_array($result)) :
          ?>
            <li>
              <a href="./class_classroom.php?cl_no=<?= $row['cl_no'] ?>&chapter_no=<?= $row['cc_chapter_no'] ?>" title="클래스 듣기">
                <p class="class_chapter_no"><?= $row['cc_chapter_no'] ?>강</p>
                <p class="class_chapter_title"><?= $row['cc_title'] ?></p>
                <img src="./images/video_play_white.svg" alt="강의듣기">
              </a>
            </li>
          <?php endwhile ?>
        </ul>
      </div>
    </main>

    <?php include('./bottom_gnb.php') ?>
  </div>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <script src="./script/header_m.js"></script>
</body>

</html>