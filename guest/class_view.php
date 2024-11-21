<?php include('./php/dbconn.php') ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스 정보</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- 클래스 정보 -->
  <link rel="stylesheet" href="./css/class_view.css">


  <!-- 제이쿼리 cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>

</head>

<body>

  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>클래스 정보</p>
  </nav>
  <main>
    <?php
    $cl_no = $_GET['cl_no'];

    $sql = "SELECT * FROM gl_class
    WHERE cl_no = '$cl_no'
";
    $result = mysqli_query($conn, $sql);
    $class = mysqli_fetch_array($result);
    ?>

    <!-- 이미지와 설명 -->
    <div class="info_top">
      <img src="../admin/images/class/<?= $class['cl_thumbnail'] ?>" alt="">
      <div class="gradation"></div>
      <div class="t_box">
        <h3><?= $class['cl_title'] ?></h3>
        <p><?= $class['cl_teacher'] ?> &#x00B7; <?= $class['cl_category'] ?></p>
        <p><?= $class['cl_desc'] ?></p>
        <p><?= $class['cl_start'] ?> ~ <?= $class['cl_end'] ?></p>
      </div>
    </div>

    <!-- 클래스 구매하기 & 정보 -->
    <div class="info_middle">
      <!-- 구매하기 -->
      <a href="#" title="구매하기" class="buy">
        <p>프라임 클래스</p>
        <p><?= $class['cl_teacher'] ?>의 모든 클래스를 기간동안 무제한 수강</p>
        <p>150,000원</p>
      </a>

      <!-- 정보 -->
      <?php
      $sql = "SELECT count(*) from gl_class_chapter where cl_no = $cl_no";
      $result = mysqli_query($conn, $sql);
      $chapter = mysqli_fetch_array($result);
      $chapter_count = $chapter[0];
      ?>
      <div class="info_card">
        <p>클래스 정보</p>
        <ul>
          <li>1. 해당 클래스는 총 <?=$chapter_count?>개의 챕터로 구성되어 있습니다.</li>
          <li>2. 자막여부 : 영어, 한국어</li>
          <li>3. 본 클래스는 ‘프라임 클래스’ 또는 ‘클래스 패스’ 중 1개 구매 시 시청 가능합니다.</li>
        </ul>
      </div>

      <!-- 찜하기 공유하기 -->
      <div class="share">
        <input type="checkbox" id="zzim">
        <label for="zzim" class="heart">찜하기</label><label for="zzim" class="zzim_txt">찜하기</label>
      <a href="#" title="공유하기"><img src="./images/share_white.svg" alt="공유하기">공유하기</a>
      
      </div>
    </div>

    <!-- 클래스 맛보기 영상 -->
    <h4>맛보기 영상</h4>
    <div class="info_video">
      <video src="../admin/images/video/<?=$class['cl_video']?>" title="클래스 맛보기영상" controls></video>
    </div>

    <!-- 클래스 상세페이지 -->
    <h4>상세페이지</h4>
    <div class="info_bottom">
    <img src="../admin/images/detail_img/<?=$class['cl_desc_image']?>" alt="클래스 상세설명 이미지">
    </div>
  </main>

  <nav class="b_nav">
  <input type="checkbox" id="zzim2">
  <label for="zzim2" class="heart">찜하기</label>
  <a href="#" title="공유하기" class="share"><img src="./images/share_white.svg" alt="공유하기"></a>

  <!-- 상태에 따른 비활성화 -->
  <?php 
  $sql = "SELECT cl_end FROM gl_class WHERE cl_end <= CURDATE() AND cl_no = '$cl_no'";
  $result = mysqli_query($conn, $sql);
  $cart_able = mysqli_fetch_array($result);

  if(mysqli_num_rows($result) == 0){
    $cart_class = "cart_btn";
    $btn_name = "장바구니";
  }
  else{
    $cart_class = "no_btn";
    $btn_name = "종료된 강의입니다";
  }

  $mb_no = $_SESSION['userno'];
  $sql_lv = "SELECT mb_level FROM gl_member WHERE mb_no = '$mb_no'";
  $result2 = mysqli_query($conn, $sql_lv);
  $mb_lv = mysqli_fetch_array($result2);

  if($mb_lv['mb_level'] == '2' || $mb_lv['mb_level'] == '3'){
    $cart_class = "no_btn";
    $btn_name = "장바구니";
  }else{
    $cart_class = "cart_btn";
    $btn_name = "장바구니";
  }

  ?>
  <a href="./php/cart_ck.php?cl_no=<?=$class['cl_no']?>" title="<?=$btn_name?>" class="<?= $cart_class?>"><?=$btn_name?></a>
  </nav>

  
</body>

</html>