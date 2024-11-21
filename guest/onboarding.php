<?php
include('./php/dbconn.php');
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css" />
  <link rel="stylesheet" href="./css/onboarding.css" />
</head>

<body>
  <div class="wrap">
    <div class="bg">
      <img src="./images/collapse.png" alt="" />
    </div>
    <div class="symbol">
      <div class="box">
        <img src="./images/home_mobile.svg" alt="그루브랩 심볼" />
        <p>세상의 모든 영감이 이곳에</p>
      </div>
    </div>

    <div class="btn_box">
      <a href="login_start.php">시작하기</a>
      <a href="index.php">둘러보기</a>
    </div>
  </div>
</body>

</html>