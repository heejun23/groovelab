<?php
// sign_pass_upload.php
include('./php/dbconn.php');

if (isset($_SESSION['mb_id'])) {
  $userid = $_SESSION['mb_id'];
  $usernik = $_SESSION['mb_nik'];
} else {
  $userid = '';
  $usernik = '';
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 비밀번호 변경</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- sign_pass_upload -->
  <link rel="stylesheet" href="./css/sign_pass_upload.css" type="text/css">
</head>

<body>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 하단 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>

  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>비밀번호 변경</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="sign_pass_upload">
      <h2 class="blind">로그인</h2>
      <div class="sign_pass_upload_top_box">
        <div class="profile_image">
          <img src="../guest/images/profile/<?= $_SESSION['userphoto'] ?>" alt="프로필사진">
        </div>
      </div>
      <form action="./php/sign_pass_upload_check.php" method="post" id="sign_pass_upload" name="비밀번호 재설정"
        class="needs-validation" novalidate onsubmit="return form_check();">

        <!-- 비밀번호 재설정 -->
        <div class="sign_pass_upload_pw_box input-group has-validation">
          <label for="mb_password">비밀번호 재설정<span> (문자, 숫자, 특수문자 포함 8-20자)</span></label>
          <input type="password" name="mb_password" id="mb_password" placeholder="새로운 패스워드를 입력하세요." autocomplete="off"
            required>
          <img src="./images/passward_mobile.svg" alt="아이디" class="sign_pass_upload_pwd">
          <div class="invalid-feedback">비밀번호를 확인해주세요.</div>
        </div>

        <!-- 비밀번호 확인 -->
        <div class="sign_pass_upload_pw_box input-group has-validation">
          <label for="mb_password_re">비밀번호 확인</label>
          <input type="password" name="mb_password_re" id="mb_password_re" placeholder="비밀번호 입력" autocomplete="off"
            required>
          <img src="./images/passward_mobile.svg" alt="비밀번호" class="sign_pass_upload_pwd2">
          <div class="invalid-feedback">비밀번호를 확인해주세요.</div>
        </div>


        <div class="sign_pass_upload_btn">
          <a href="mypage.php" class="sign_pass_upload_back_btn">돌아가기</a>
          <input type="submit" id="sign_pass_upload_pw_check_btn" value="정보수정">
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
  <!-- 부트스트랩 cdn-->
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

  <!-- 유효성 검사 -->
  <script>
    function form_check() {
      // alert($('.id.valid-feedback').text().trim() != "중복되지 않는 아이디입니다.");
      let result = true;
      let pwreg = /^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$/;

      if ($('#mb_password').val().length < 1) {
        alert('비밀번호를 입력해 주세요.');
        result = false;
      } else if (false === pwreg.test($('#mb_password').val())) {
        alert('비밀번호는 8자 이상 20자 이하 영문 숫자 특수문자(#?!@$%^&*-) 조합이어야 합니다.');
        result = false;
      } else if ($('#mb_password').val() !== $('#mb_password_re').val()) {
        alert('비밀번호가 일치하지 않습니다.');
        result = false;
      }
      return result;
    }
  </script>
</body>

</html>