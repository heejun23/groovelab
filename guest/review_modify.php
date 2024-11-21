<?php
include('./php/dbconn.php');
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스 평가 수정</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- review_modify.css -->
  <link rel="stylesheet" href="./css/review_modify.css" type="text/css">

</head>

<body>
  <?php
  $review_no = $_GET['review_no'];
  $sql = "SELECT cl_no FROM gl_review WHERE review_no = '$review_no'";
  $result = mysqli_query($conn, $sql);
  $no = mysqli_fetch_array($result);
  $cl_no = $no['cl_no'];


  $sql = "select cl_category, cl_teacher, cl_title, cl_thumbnail from gl_class where cl_no='$cl_no'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result); ?>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 하단 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>클래스 평가 수정</p>
  </nav>


  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="review_upload">
      <h2 class="blind">클래스 평가 수정</h2>
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
            <p class="review_title"><?php echo $_SESSION['usernick'] ?></p>
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
      <form action="./php/review_modify_check.php?review_no=<?php echo $row2['review_no'] ?>" name="review_upload" method="post" id="reivew_upload" onsubmit="return formCheck();" class="needs-validation" novalidate>
        <div class="sreview_upload_star">
          <h3>클래스는 만족 하셨나요?</h3>
          <div class="rv_star">
            <input type="radio" name="rv_star" class="star2" value="1" id="rv_star1" required>
            <input type="radio" name="rv_star" class="star2" value="2" id="rv_star2" required>
            <input type="radio" name="rv_star" class="star2" value="3" id="rv_star3" required>
            <input type="radio" name="rv_star" class="star2" value="4" id="rv_star4" required>
            <input type="radio" name="rv_star" class="star2" value="5" id="rv_star5" required>
          </div>
        </div>
        <!-- qna 텍스트내용 -->
        <div class="qna_upload_txt_box">
          <textarea name="rv_content" id="rv_content" cols="30" rows="8" placeholder="다른 학생들이 도움이 될 수 있게 리뷰를 작성해 주세요!" required><?php echo $row2['rv_content'] ?></textarea>
          <div class="invalid-feedback">평가하실 내용을 작성해주세요.</div>
        </div>

        <!-- qna 질문등록 박스 -->
        <div class="qna_upload_btn_box">
          <a href="#" onclick="goBack();" class="qna_upload_cbtn">수정취소</a>
          <input type="submit" name="qna_upload_btn" id="qna_upload_btn" value="평가수정">
        </div>
      </form>
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

    function formCheck() {
      // 라디오 버튼의 name 속성으로 그룹화된 모든 라디오 버튼 선택
      const radioButtons = document.getElementsByName("rv_star");

      // 선택된 라디오 버튼이 있는지 확인
      let isChecked = false;
      for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
          isChecked = true;
          break;
        }
      }

      // 선택된 라디오 버튼이 없으면 오류 메시지 표시
      if (!isChecked) {
        alert("별점을 선택해주세요.");
        return false; // 폼 제출 방지
      }

      return true; // 폼 제출 허용
    }
  </script>
</body>

</html>