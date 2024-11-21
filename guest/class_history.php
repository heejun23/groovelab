<?php include('./php/dbconn.php') ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 수강종료된 클래스</title>
    <!-- 파비콘 -->
    <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- 진행중인 클래스 css -->
  <link rel="stylesheet" href="./css/class_ongoing.css">


  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 차트js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</head>

<body>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>수강종료된 클래스</p>
  </nav>

  <main>
  <section id="con">

    <?php

    $mb_no = $_SESSION['userno'];

    $sql = "SELECT
cl_category,
cl_title,
cl_teacher,
cl_thumbnail,
cl_start,
cl_end,
gc.cl_no,
progress
FROM gl_class AS gc
INNER JOIN gl_class_member AS gcm ON gc.cl_no = gcm.cl_no
INNER JOIN gl_member AS gm ON gm.mb_no = gcm.mb_no
WHERE gc.cl_end <= CURDATE()
AND gcm.cm_status IN (2,3)
AND gm.mb_no = '$mb_no'
ORDER BY gc.cl_end DESC
";
    $result = mysqli_query($conn, $sql);

    // 진행 클래스 없는 경우
    if (mysqli_num_rows($result) == 0) {  ?>
      <div class="no_info">
        <img src="./images/out_of_stock.png" alt="정보없음">
        <p>종료된 클래스가 없습니다.</p>
      </div>
      <?php } else {
      //반복
      while ($my = mysqli_fetch_array($result)) { ?>
        <!-- 해당내용 -->
        <div class="card_wrap">
          <a href="./class_view.php?cl_no=<?= $my['cl_no'] ?>" class="myclass">
            <div class="img_box end_img">
              <img src="../admin/images/class/<?= $my['cl_thumbnail'] ?>" alt="">
            </div>
            <div class="t_box">
              <h4><?= $my['cl_title'] ?></h4>
              <p><?= $my['cl_teacher'] ?> &#x00B7; <?= $my['cl_category'] ?></p>
              <p>수강종료일 : <?= $my['cl_end'] ?></p>
              <!-- 차트 -->
              <div class="chart_box end_chart">
                <div class="chart" data-cl_no="<?= $my['cl_no']; ?>" data-mb_no="<?= $mb_no ?>"></div>
                <span><?= $my['progress'] ?>%</span>
              </div>

            </div>
            <input type="hidden" value="<?= $my['cl_no'] ?>" class="cl_no">
            <input type="hidden" value="<?= $mb_no ?>" class="mb_no">
          </a>
        </div>

    <?php }
    } ?>
        </section>
  </main>
  <script>
    $(document).ready(function() {
      $('.chart').each(function() {
        let chart = $(this);
        let cl_no = chart.data('cl_no');
        let mb_no = chart.data('mb_no');

        $.post(
          "./php/progress.php", {
            cl_no: cl_no,
            mb_no: mb_no
          },
          function(data) {
            // console.log(data)
            if (data) {
              let numData = (parseFloat(data) / 100) * 360; // 문자열을 숫자로 변환하고 그래프에 맞는 진행도로 변환
              chart.css('background', 'conic-gradient(#000 0deg, #000 ' + numData + 'deg, #eee 0deg)');
              // console.log(numData)
            }
          }
        )
      });
    });
  </script>
</body>

</html>