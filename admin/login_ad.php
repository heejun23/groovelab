<?php
// login_ad.php
include ('./php/dbconn.php');


?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 파비콘 -->
    <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
    <!-- css서식 초기화 -->
    <link rel="stylesheet" href="./css/reset.css" type="text/css">
    <!-- 스타일 서식 -->
    <link rel="stylesheet" href="./css/login_ad.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>그루브랩 : 관리자로그인</title>
</head>

<body>
    <main>
        <section class="login_ad">
            <h2><img src="./images/logo_blackColor.svg" alt="로고"></h2>
            <p>환영합니다!<span>관리자</span>계정으로 로그인해주세요.</p>

            <!-- 로그인 폼양식 -->
            <form action="./php/login_ad_check.php" name="login_ad" method="post" id="login_ad_form">
                <!-- 아이디입력 -->
                <div class="login_ad_id_box">
                    <input type="text" placeholder="아이디를 입력하세요." id="mb_id" name="mb_id">
                    <img src="./images/account_admin.svg" alt="아이디">
                </div>

                <!-- 비밀번호입력 -->
                <div class="login_ad_pw_box">
                    <input type="password" placeholder="비밀번호를 입력하세요." id="mb_password" name="mb_password">
                    <img src="./images/password_admin.svg" alt="비밀번호">
                </div>

                <div class="login_ad_checkbox">
                    <input type="checkbox" id="id_check"> <label for="id_check">아이디저장</label>
                </div>

                <p>
                    <input type="submit" id="login_ad_btn" value="로그인">
                </p>
            </form>
        </section>
    </main>

    <!-- 자바스크립트 쿠키 (아이디저장) 라이브러리 -->
    <script src="./script/javascript_cookie.js"></script>
    <!-- 아이디 쿠키저장 스크립트 -->
    <script>
        $(document).ready(function () {
            let key = getCookie('idChk'); //쿠키이름 저장
            if (key != "") { //만약에 key변수에 값이 있으면
                $('#mb_id').val(key); //id 값을 지정
            }
            if ($('#mb_id').val() != "") { //만약 id값이 있다면
                $('#id_check').attr('checked', true);  //체크박스에 체크를 해준다.
            }
            $('#id_check').change(function () { //체크박스의 상태가 연결되면 아래내용을 실행.
                if ($('#id_check').is(':checked')) { //체크박스에 체크가 된경우라면
                    setCookie('idChk', $('#mb_id').val(), 7); //쿠키를 생성하고
                } else { //그렇지 않으면
                    deleteCookie('idChk'); //쿠키를 삭제한다.
                }
            });

            $('#mb_id').keyup(function () { //아이디 입력창에 키를 눌렀을 경우
                if ($('#id_check').is(':checked')) { //체크박스에 체크가 된 경우라면
                    setCookie('idChk', $('#mb_id').val(), 7); //쿠키를 생성한다.
                }
            });
        })
    </script>
</body>

</html>