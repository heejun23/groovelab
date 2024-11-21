<?php
include('./php/dbconn.php');
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <?php $mb_no = $_SESSION["userno"];

  $sql = "select mb_level from gl_member where mb_no = '$mb_no'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $mb_level = $row[0]; //로그인한 사람의 mb_level;

  // 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
  if ($mb_level == 1) {
  } else if ($mb_level == 2) {
  } else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
    echo "<script>alert('로그인후 접근할 수 있습니다.');</script>";
    echo "<script>location.replace('./login_start.php');</script>";
  }
  $cl_no = $_GET['cl_no'];
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 공지사항 등록</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- notice_upload.css -->
  <link rel="stylesheet" href="./css/notice_upload.css" type="text/css">

</head>

<body>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php'); ?>
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>공지사항 등록</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="qna_upload">
      <h2 class="blind">공지사항등록</h2>
      <!-- qna 질문 제목 -->
      <form action="./php/notice_update.php?cl_no=<?= $cl_no ?>" name="qna_upload" method="post" id="qna_upload" onsubmit="return formCheck();" class="needs-validation" novalidate>
        <div class="qna_upload_title_box">
          <label for="no_title">제목</label>
          <input type="text" name="no_title" id="no_title" placeholder="제목을 입력하세요." required>
          <div class="invalid-feedback">제목을 입력해주세요.</div>
        </div>
        <!-- qna 회원 닉네임 -->
        <?php
        $usernick = $_SESSION['usernick'];
        $sql = "select * from gl_member where mb_nick='$usernick'";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="qna_upload_nickname_box">
          <label for="mb_nick">닉네임</label>
          <input type="text" name="mb_nick" id="mb_nick" value="<?php echo $usernick ?>" readonly>
        </div>
        <!-- qna 텍스트내용 -->
        <div class="qna_upload_txt_box">
          <textarea name="no_content" id="no_content" cols="30" rows="10" placeholder="질문의 내용을 작성해 주세요!" required></textarea>
          <div class="invalid-feedback">공지하실 내용을 작성해주세요.</div>
        </div>

        <!-- qna 질문등록 박스 -->
        <div class="qna_upload_btn_box">
          <a href="#" onclick="goBack();" class="qna_upload_cbtn">등록취소</a>
          <input type="submit" name="qna_upload_btn" id="qna_upload_btn" value="등록완료">
        </div>
      </form>
    </section>
  </main>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
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