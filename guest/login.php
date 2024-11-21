<?php
include('./php/dbconn.php');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 로그인</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- 부트스트랩 cdn css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- login.php 스타일 시트 -->
  <link rel="stylesheet" href="./css/login.css" type="text/css">
</head>
<body>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>로그인</p>
  </nav>

    <!-- 메인콘텐츠 영역 -->
    <main>
      <section class="login">
        <h2 class="blind">로그인</h2>
        <form action="./php/login_check.php" method="post" id="login_form" name="로그인폼" class="needs-validation" novalidate>
          
          <!-- 아이디 입력 -->
          <div class="login_id_box">
            <input type="text" name="mb_id" id="mb_id" placeholder="아이디를 입력해주세요." autocomplete="off" required>
            <img src="./images/id_mobile.svg" alt="아이디" class="login_id">
            <div class="invalid-feedback">아이디를 확인해주세요.</div>
          </div>

          <!-- 비밀번호 입력 -->
          <div class="login_pw_box input-group has-validation">
            <label class="blind">&nbsp;</label>
            <input type="password" name="mb_password" id="mb_password" placeholder="비밀번호를 입력해주세요." aria-describedby="inputGroupPrepend" autocomplete="off" required>
            <img src="./images/passward_mobile.svg" alt="비밀번호" class="login_pwd">
            <div class="invalid-feedback">비밀번호를 확인해주세요.</div>
          </div>

          <div class="login_id_check">
            <p>
              <input type="checkbox" id="id_check" name="id_check">
              <label for="id_check">아이디 저장</label> 
            </p>

            <p>
              <a href="#">아이디 찾기</a>
              <a href="#">비밀번호 찾기</a>
            </p>

          </div>

          <div class="login_btn">
            <input type="submit" id="login_btn" value="로그인">
          </div>
        </form>

        <div class="login_simplelogin">
          <p>간편로그인</p>
          <p class="login_simple_box">
            <a href="javascript:void(0);" onclick="kakaoLogin()" title="카카오 로그인"><img src="./images/kakao_login.png" alt="카카오로그인"></a>
            <a href="#"><img src="./images/naver_login.png" alt="네이버로그인"></a>
            <a href="#"><img src="./images/google_login.png" alt="구글로그인"></a>
          </p>
        </div>

        <div class="join_us">
        <p class="login_start_sign">아직 회원이 아니신가요? <a href="sign.php">회원가입</a></p>
        </div>
      </section>
    </main>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 자바스크립트 쿠키 (아이디저장) 라이브러리 -->
  <script src="./script/javascript_cookie.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 카카오 로그인 (라이브러리) -->
  <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
  <!-- 부트스트랩 cdn 스크립트 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- 카카오 로그인 스크립트-->
  <script>
    Kakao.init('eae1a42f5aae28538a34a719867bc196');
    // sdk초기화여부판단 
    console.log(Kakao.isInitialized());
    //카카오로그인 
    function kakaoLogin() {
    //Kakao.Auth.authorize()
    Kakao.Auth.login({
      success: function (response) {
        Kakao.API.request({ 
        url: '/v2/user/me', success: function (response) {
            console.log(response)
            }, fail: function (error) { 
            console.log(error)
            }, 
          })
          }, fail: function (error) { 
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
    }}
  </script>

  <!-- 아이디 쿠키저장 스크립트 -->
  <script>
    $(document).ready(function(){
      let key = getCookie('idChk'); //쿠키이름 저장
      if(key != ""){ //만약에 key변수에 값이 있으면
        $('#mb_id').val(key); //id 값을 지정
      }
      if($('#mb_id').val() != ""){ //만약 id값이 있다면
        $('#id_check').attr('checked', true);  //체크박스에 체크를 해준다.
      }
      $('#id_check').change(function(){ //체크박스의 상태가 연결되면 아래내용을 실행.
        if($('#id_check').is(':checked')){ //체크박스에 체크가 된경우라면
          setCookie('idChk', $('#mb_id').val(), 7); //쿠키를 생성하고
        }else{ //그렇지 않으면
          deleteCookie('idChk'); //쿠키를 삭제한다.
        }
      });
      
      $('#mb_id').keyup(function(){ //아이디 입력창에 키를 눌렀을 경우
        if($('#id_check').is(':checked')){ //체크박스에 체크가 된 경우라면
          setCookie('idChk', $('#mb_id').val(), 7); //쿠키를 생성한다.
        }
      });
    })
  </script>

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