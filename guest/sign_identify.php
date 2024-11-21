<?php include('./php/dbconn.php') ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 본인인증</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- sign_identify.css -->
  <link rel="stylesheet" href="./css/sign_identify.css" type="text/css">
</head>

<body>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 하단 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>

  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>본인인증</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="sign_identify">
      <h2 class="blind">로그인</h2>
      <div class="sign_identify_top_box">
        <p>회원정보 수정을 계속 하려면 먼저 본인인증을 진행하세요.</p>
        <?php
        $mb_no = $_SESSION['userno'];
        $query = "SELECT * FROM gl_member where mb_no = $mb_no";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        ?>
        <img src="../guest/images/profile/<?= $row['mb_photo'] ?>" alt="프로필사진">
      </div>
      <form action="./php/sign_identify_check.php" method="post" id="sign_identify_form" name="본인인증폼" class="needs-validation" novalidate>

        <!-- 아이디 입력 -->
        <div class="sign_identify_email_box input-group has-validation">
          <label for="mb_email">이메일</label>
          <input type="email" name="mb_email" id="mb_email" placeholder="userid@email.com" autocomplete="off" required>
          <img src="./images/email_mobile.svg" alt="아이디" class="sign_identify_email">
          <div class="invalid-feedback">이메일을 확인해주세요.</div>
        </div>

        <!-- 비밀번호 입력 -->
        <div class="sign_identify_pw_box input-group has-validation">
          <label for="mb_email">비밀번호 <span>(문자, 숫자, 특수문자 포함 8-20자)</span></label>
          <input type="password" name="mb_password" id="mb_password" placeholder="비밀번호 입력" autocomplete="off" required>
          <img src="./images/passward_mobile.svg" alt="비밀번호" class="sign_identify_pwd">
          <div class="invalid-feedback">비밀번호를 확인해주세요.</div>
        </div>


        <div class="sign_identify_btn">
          <a href="mypage.php" class="sign_identify_back_btn">돌아가기</a>
          <input type="submit" id="sign_identify_pw_check_btn" value="비밀번호 확인">
        </div>
      </form>
    </section>
  </main>

  <!-- 제이쿼리 라이브러리 -->
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