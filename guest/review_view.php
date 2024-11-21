<?php
// login.php
include('./php/dbconn.php');

$review_no = $_GET['review_no'];
$sql_r = "select * from gl_review where review_no='$review_no'";
$result_r = mysqli_query($conn, $sql_r);
$row_r = mysqli_fetch_array($result_r);

$cl_no = $row_r['cl_no'];

$sql = "select cl_category, cl_title, cl_teacher, cl_thumbnail from gl_class where cl_no='$cl_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스 평가 상세</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- review_view.css -->
  <link rel="stylesheet" href="./css/review_view.css" type="text/css">

</head>

<body>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 하단 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>클래스 평가 상세</p>
  </nav>
  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="review_upload">
      <h2 class="blind">클래스 평가 상세</h2>
      <!-- qna 질문 제목 -->
      <div class="review_class_box">
        <div class="review_class_img">
          <img src="../admin/images/class/<?php echo $row['cl_thumbnail'] ?>" alt="강의사진">
        </div>
        <div class="review_class_txt">
          <p class="title"><?php echo $row['cl_title'] ?></p>
          <p class="cate"><?= $row['cl_teacher'] ?> &#x00B7; <?php echo $row['cl_category'] ?></p>
          <?php
          $sql2 = "select * from gl_review where review_no='$review_no'";
          $result2 = mysqli_query($conn, $sql2);
          $row2 = mysqli_fetch_array($result2);
          $mb_no = $row2["mb_no"];
          $sql3 = "select mb_nick from gl_member where mb_no = $mb_no";
          $result3 = mysqli_query($conn, $sql3);
          $row3 = mysqli_fetch_array($result3);
          $mb_nick = $row3[0];
          ?>
          <div class="star">
            <div class="review_star">
              <!-- 색이없음 -->
              <img src="./images/review_star_noneColor.svg" alt="별">
              <img src="./images/review_star_noneColor.svg" alt="별">
              <img src="./images/review_star_noneColor.svg" alt="별">
              <img src="./images/review_star_noneColor.svg" alt="별">
              <img src="./images/review_star_noneColor.svg" alt="별">
            </div>
            <div class="review_star" style="width:calc(<?php echo $row2['rv_star'] ?>*25px);">
              <!-- 색이 있음 -->
              <img src="./images/review_star_mainColor.svg" alt="별">
              <img src="./images/review_star_mainColor.svg" alt="별">
              <img src="./images/review_star_mainColor.svg" alt="별">
              <img src="./images/review_star_mainColor.svg" alt="별">
              <img src="./images/review_star_mainColor.svg" alt="별">
            </div>
          </div>
          <div class="review_view_nick_date">
            <p class="review_title"><?php echo $mb_nick ?></p>
            <p class="review_date"><?php echo substr($row2['rv_datetime'], 0, 10) ?></p>
          </div>
        </div>
      </div>
      <!-- qna 회원 닉네임 -->
      <?php
      $usernick = $_SESSION['usernick'];
      $sql = "select * from gl_member where mb_nick='$usernick'";
      $result = mysqli_query($conn, $sql);
      ?>
      <!-- 클래스평가 텍스트내용 -->
      <div class="rv_content">
        <div><?php echo nl2br($row2['rv_content']) ?></div>
      </div>

      <?php
      $mb_no = $_SESSION['userno'];
      $query = "select mb_level from gl_member where mb_no='$mb_no'";
      $result_mb = mysqli_query($conn, $query);
      $mb = mysqli_fetch_array($result_mb);
      if ($mb['mb_level'] == 1) {
      ?>
        <!-- 수정 btn -->
        <div class="qna_view_btn">
          <a href="review_modify.php?review_no=<?php echo $row2['review_no'] ?>" id="qna_view_edit"><img src="./images/edit_black.svg" alt="수정">수정</a>
        </div>
      <?php  } ?>
    </section>
  </main>

  <!-- 제이쿼리 cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
  <!-- 부트스트랩 cdn 스크립트 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- 부트스트랩 스크립트 -->
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>

</html>