<?php
include('./php/dbconn.php');
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 로그인페이지</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- login_start.css -->
  <link rel="stylesheet" href="./css/login_start.css" type="text/css">
</head>

<body>
  <!-- 헤드 -->
  <nav id="head">
    <a href="index.php" title="뒤로가기"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>&nbsp;</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="login_start">
      <div class="login_start_img_box">
        <img src="./images/login_start_img.png" alt="로그인이미지">
      </div>

      <div class="login_start_simplelogin">
        <p>
          <a href="javascript:void(0);" onclick="kakaoLogin()" title="카카오 로그인"><img src="./images/kakao_login.png" alt="카카오로그인">카카오 로그인</a>
        </p>
        <p>
          <a href="#"><img src="./images/naver_login.png" alt="네이버로그인">네이버 로그인</a>
        </p>
        <p>
          <a href="#"><img src="./images/google_login.png" alt="구글로그인">구글 로그인</a>
        </p>
      </div>

      <p class="login_start_login_btn">
        <a href="login.php">로그인</a>
      </p>
      
      <p class="login_start_sign">아직 회원이 아니신가요? <a href="sign.php">회원가입</a></p>
    </section>
  </main>




  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
  <script>
    Kakao.init('eae1a42f5aae28538a34a719867bc196');

    // sdk초기화여부판단 
    console.log(Kakao.isInitialized());

    //카카오로그인 
    function kakaoLogin() {
      //Kakao.Auth.authorize()
      Kakao.Auth.login({
        success: function(response) {
          Kakao.API.request({
            url: '/v2/user/me',
            success: function(response) {
              console.log(response)
            },
            fail: function(error) {
              console.log(error)
            },
          })
        },
        fail: function(error) {
          console.log(error)
        },
      })
    }

    //카카오로그아웃 
    function kakaoLogout() {
      if (Kakao.Auth.getAccessToken()) {
        Kakao.API.request({
            url: '/v1/user/unlink',
          })
          .then(function(response) {
            console.log(response);
          })
          .catch(function(error) {
            console.log(error);
          });
        Kakao.Auth.setAccessToken(undefined)
      }
    }
  </script>
</body>

</html>