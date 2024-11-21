<?php
include("./php/dbconn.php");
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 회원수정</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <link rel="stylesheet" href="./css/reset.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/sign_upload.css">
</head>

<body>
  <?php
  $mb_no = $_SESSION["userno"];
  $sql = "SELECT * FROM gl_member where mb_no = $mb_no";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result); ?>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php') ?>
  <div class="mobile_wrap">
    <!-- 헤드 -->
    <nav id="head">
      <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
      <p>정보수정</p>
    </nav>
    <main>

      <form name="register_form" action="./php/sign_modify.php" method="post" class="needs-validation regi_form" novalidate onsubmit="return form_check();" enctype="multipart/form-data">
        <div class="sign_profile">
          <div class="sign_profile_photo">
            <img src="./images/profile/<?= $row['mb_photo'] ?>" alt="프로필 사진">
          </div>
          <label for="sign_profile_photo" class="sign_image_upload"><img src="./images/edit_white.svg" alt="이미지 첨부"></label>
          <input type="file" name="sign_profile_photo" id="sign_profile_photo" accept="image/gif, image/jpeg, image/jpg, image/png" onchange="setThumbnail(event);">
          <input type="hidden" name="profile_default" value="<?= $row['mb_photo'] ?>">
        </div>

        <!-- mb_no -->
        <input type="hidden" name="mb_no" id="mb_no" value="<?= $mb_no ?>">

        <div class="sign_input_form">
          <div>
            <label for="mb_name" class="form-label">이름</label>
            <div class="sign_input_box">
              <img src="./images/edit_mobile.svg" alt="이름">
              <input type="text" name="mb_name" id="mb_name" maxlength="25" class="form-control" autocomplete="off" placeholder="이름을 입력해주세요." required value="<?= $row['mb_name'] ?>">
              <div class="invalid-feedback">
                이름을 입력해주세요(25자 이내)
              </div>
            </div>
          </div>

          <label for="mb_nick" class="form-label">닉네임</label>
          <div>
            <div class="sign_input_box">
              <img src="./images/edit_mobile.svg" alt="닉네임">
              <input type="text" name="mb_nick" id="mb_nick" class="form-control" autocomplete="off" placeholder="닉네임을 입력해주세요." maxlength="25" required value="<?= $row['mb_nick'] ?>">
              <div class="valid-feedback nick">
                사용가능한 닉네임입니다.
              </div>
              <div class="invalid-feedback">
                닉네임을 입력해주세요.
              </div>
            </div>
          </div>

          <label for="mb_email" class="form-label">이메일</label>
          <div>
            <div class="sign_input_box">
              <img src="./images/email_mobile.svg" alt="이메일">
              <input type="email" name="mb_email" id="mb_email" class="form-control" autocomplete="off" placeholder="예) asdaf@naver.com" required value="<?= $row['mb_email'] ?>">
              <div class="valid-feedback email">
                사용가능한 이메일입니다.
              </div>
              <div class="invalid-feedback">
                이메일을 입력해주세요.
              </div>
            </div>
          </div>

          <div>
            <label for="mb_tel" class="form-label">전화번호</label>
            <div class="sign_input_box">
              <img src="./images/tel_mobile.svg" alt="전화번호">
              <input type="text" name="mb_tel" id="mb_tel" class="form-control" autocomplete="off" placeholder="전화번호 입력(‘-’제외 숫자 11자리 입력)" maxlength="11" value="<?= $row['mb_tel'] ?>">
            </div>
          </div>

          <div class="interest">
            <p>관심클래스</p>
            <div class="d-flex">
              <input type="checkbox" name="mb_interest[]" id="cate01" value="cate01" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate01") !== false ? "checked" : "" : "" ?>>
              <label for="cate01">보컬</label>
              <input type="checkbox" name="mb_interest[]" id="cate02" value="cate02" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate02") !== false ? "checked" : "" : "" ?>>
              <label for="cate02">힙합</label>
              <input type="checkbox" name="mb_interest[]" id="cate03" value="cate03" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate03") !== false ? "checked" : "" : "" ?>>
              <label for="cate03">뮤지컬/재즈/클래식</label>
              <input type="checkbox" name="mb_interest[]" id="cate04" value="cate04" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate04") !== false ? "checked" : "" : "" ?>>
              <label for="cate04">프로듀싱</label>
              <input type="checkbox" name="mb_interest[]" id="cate05" value="cate05" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate05") !== false ? "checked" : "" : "" ?>>
              <label for="cate05">작사/작곡</label>
              <input type="checkbox" name="mb_interest[]" id="cate06" value="cate06" <?= isset($row['mb_interest']) ? strpos($row['mb_interest'], "cate06") !== false ? "checked" : "" : "" ?>>
              <label for="cate06">음향관리/엔지니어링</label>
            </div>
          </div>
        </div>

        <p class="sign_pw_reset">비밀번호를 변경하고 싶으신가요?<br> <a href="./sign_pass_upload.php">비밀번호 재설정</a></p>

        <div class="sign_submit_btn">
          <a href="./mypage.php">돌아가기</a>
          <input type="submit" value="정보수정">
        </div>

      </form>
    </main>


  </div>
  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
  <!-- 부트스트랩 스크립트 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./script/sign_upload.js"></script>
</body>

</html>