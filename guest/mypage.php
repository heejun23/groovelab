<?php
include ("./php/dbconn.php");
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 마이페이지</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- mypage 스타일 시트 -->
  <link rel="stylesheet" href="./css/mypage.css" type="text/css">

</head>

<body>
  <?php
  $mb_level = $_SESSION['userlevel']; //로그인한 사람의 mb_level;
  
  // 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
  if (!isset($_SESSION['userlevel'])) {
    echo "<script>alert('로그인이 필요한 서비스입니다.');</script>";
    echo "<script>location.replace('./login_start.php');</script>";
  }
  ?>
  <!-- 헤더 -->
  <?php include ('./header_m.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>마이페이지</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="mypage">
      <h2 class="blind">마이페이지</h2>
      <?php
      $mb_no = $_SESSION['userno'];
      $query = "SELECT * FROM gl_member where mb_no = $mb_no";
      $result = mysqli_query($conn,$query);
      $row = mysqli_fetch_array($result);
      ?>
      <p class="mypage_logout"><a href="./php/logout.php" title="로그아웃">로그아웃</a></p>
      <div class="mypage_profile">
        <div class="mypage_profile_photo">
          <img src="./images/profile/<?= $row['mb_photo'] ?>" alt="프로필 사진">
        </div>
        <a href="./sign_identify.php" class="mypage_sign_identify" title="회원정보 수정">
          <img src="./images/edit_white.svg" alt="회원정보 수정">
        </a>
      </div>
      <p class="mypage_nick"><?= $row['mb_nick'] ?></p>

      <?php
      $mb_level = $_SESSION['userlevel'];
      if ($mb_level == 2) { ?>
        <div class="mypage_t_wrap">
          <div class="mypage_link_list">
            <div></div>
            <a href="./class_creator_student.php" title="수강생 관리 바로가기">수강생 관리 <img src="./images/arrow_down_white.svg"
                alt="바로가기"></a>
            <a href="./class_creater_ongoing.php" title="진행중인 클래스 바로가기">진행중인 클래스 <img src="./images/arrow_down_white.svg"
                alt="바로가기"></a>
            <a href="./class_creater_history.php" title="종료된 클래스 바로가기">종료된 클래스 <img src="./images/arrow_down_white.svg"
                alt="바로가기"></a>
            <a href="./class_creater_review.php" title="클래스 평가 열람 바로가기">클래스 평가 열람 <img src="./images/arrow_down_white.svg"
                alt="바로가기"></a>
          </div>
        </div>
      <?php } else if ($mb_level == 1) { ?>
          <div class="mypage_s_wrap">
            <?php
            $mb_no = $_SESSION['userno'];
            $sql = "SELECT mb_point from gl_member where mb_no = $mb_no";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $point = $row["mb_point"];
            ?>
            <p class="mypage_point"><img src="./images/point_mobile.svg" alt="포인트"><?= $point ?></p>

            <div class="mypage_s_link">
              <a href="./cart.php" title="장바구니 바로가기"><img src="./images/cart_white.svg" alt="장바구니">장바구니</a>
              <a href="./review_mypage.php" title="클래스평가 바로가기"><img src="./images/class_review_white.svg"
                  alt="클래스평가">클래스평가</a>
              <a href="#" title="활동기록 바로가기"><img src="./images/board_white.svg" alt="활동기록">활동기록</a>
            </div>

            <div class="mypage_link_list">
              <div></div>
              <a href="./class_ongoing.php" title="수강중인 클래스 바로가기">수강중인 클래스 <img src="./images/arrow_down_white.svg"
                  alt="바로가기"></a>
              <a href="./class_history.php" title="수강종료된 클래스 바로가기">수강종료된 클래스 <img src="./images/arrow_down_white.svg"
                  alt="바로가기"></a>
              <a href="#" title="찜한 클래스 바로가기">찜한 클래스 <img src="./images/arrow_down_white.svg" alt="바로가기"></a>
            </div>
          </div>
      <?php } ?>
    </section>
  </main>
  <?php include ('./bottom_gnb.php'); ?>
  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</body>

</html>