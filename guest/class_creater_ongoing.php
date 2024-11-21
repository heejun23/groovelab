<?php include('./php/dbconn.php') ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 진행중인 클래스</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- 진행중인 클래스 css -->
  <link rel="stylesheet" href="./css/class_ongoing.css">

  <!-- 제이쿼리 cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</head>

<body>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 바텀 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>진행중인 클래스</p>
  </nav>

  <main>
    <section id="con">
      <h2 class="blind">진행중인 클래스</h2>
      <?php

      $mb_no = $_SESSION['userno'];

      $sql = "SELECT
            cl_category,
            cl_title,
            cl_teacher,
            cl_thumbnail,
            cl_no,
            cl_start,
            cl_end
            FROM gl_class AS gc
            INNER JOIN gl_member AS gm ON gm.mb_no = gc.mb_no
            WHERE gc.cl_end > CURDATE()
            AND gc.cl_start <= CURDATE()
            AND gc.mb_no = '$mb_no'
            ORDER BY gc.cl_start DESC
            ";
      $result = mysqli_query($conn, $sql);
      // 진행 클래스 없는 경우
      if (mysqli_num_rows($result) == 0) {  ?>
        <div class="no_info">
          <img src="./images/out_of_stock.png" alt="정보없음">
          <p>진행중인 클래스가 없습니다.</p>
        </div>
        <?php } else {
        //반복
        while ($my = mysqli_fetch_array($result)) {
          $cl_no = $my['cl_no'];

        ?>
          <!-- 해당내용 -->
          <div class="card_wrap">
            <a href="./class_mypage_view.php?cl_no=<?= $my['cl_no'] ?>" class="myclass">
              <div class="img_box">
                <img src="../admin/images/class/<?= $my['cl_thumbnail'] ?>" alt="">
              </div>
              <div class="t_box">
                <h4><?= $my['cl_title'] ?></h4>
                <p><?= $my['cl_teacher'] ?> &#x00B7; <?= $my['cl_category'] ?></p>
                <p><?= $my['cl_start'] ?> ~ <?= $my['cl_end'] ?></p>
              </div>
              <div class="photo_box">
                <?php

                //사진 나오게하기
                $sql2 = "SELECT mb_photo
                      FROM gl_member gm
                      INNER JOIN gl_class_member gcm ON gm.mb_no = gcm.mb_no
                      WHERE gcm.cm_status = 1 AND gcm.cl_no = '$cl_no'
                      ORDER BY gcm.cm_randate DESC
                      LIMIT 5;";
                $result2 = mysqli_query($conn, $sql2);
                if (!$result2) {
                  die('에러 : ' . mysqli_error($conn));
                }
                while ($photo = mysqli_fetch_array($result2)) {
                ?>
                  <img src="./images/profile/<?= $photo['mb_photo'] ?>" alt="회원사진">
                <?php } ?>
              </div>
            </a>
          </div>
      <?php }
      } ?>

    </section>
  </main>
</body>

</html>