<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩 : 관리자 홈</title>
  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/mypage_ad.css" />

  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- 헤더 -->
  <script src="./script/header.js"></script>
  <!-- 차트js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- 날짜js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
</head>

<body>

<?php
include ('./php/dbconn.php');
$mb_no = $_SESSION['userno'];

$sql = "select mb_level from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_level = $row[0]; //로그인한 사람의 mb_level;

// 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
if ($mb_level == 2) {
} else if ($mb_level == 3) {
  echo "<script>alert('크리에이터 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
} else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
  echo "<script>alert('크리에이터 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
}

?>

  <?php include ('./header_t.php') ?>
  <main>
    <div id="mypage" class="wrap">
      <!-- 왼쪽 반 -->
      <section id="left">
        <h2 class="blind">크리에이터 메인</h2>
        <!-- 1. 방문자 현황조회 -->
        <article id="visitor">
          <h2>나의 클래스 수강신청 현황</h2>
          <div>
            <canvas id="myChart"></canvas>
          </div>
        </article>

        <div class="wrap2">
          <!-- 2. 최근 결제내역 -->
          <article id="sell_list">
            <?php
            $sql = "SELECT count(*) FROM gl_class_member WHERE cm_datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND cl_no IN(SELECT cl_no FROM gl_class where mb_no = $mb_no);";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $recent_pay_count = $row[0];
            ?>
            <h2>최근 결제 내역 <span><?= $recent_pay_count ?></span></h2>
            <a href="#" title="최근결제내역"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>

            <?php
            $sql = "SELECT * FROM gl_class_member WHERE cm_datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND cl_no IN(SELECT cl_no FROM gl_class where mb_no = $mb_no) ORDER BY cm_no DESC limit 2;";
            $result = mysqli_query($conn, $sql);
            $rowCount = 0;
            while ($row = mysqli_fetch_array($result)) {
              $rowCount++;
              $cl_no = $row['cl_no'];
              $sql = "SELECT * FROM gl_class where cl_no = $cl_no";
              $class_result = mysqli_query($conn, $sql);
              $class_row = mysqli_fetch_array($class_result);
              ?>
              <a href="./class_ad_view.php?cl_no=<?= $cl_no ?>" title="결제 내역" class="sell_con">
                <div class="mini_thum">
                  <img src="./images/class/<?= $class_row['cl_thumbnail'] ?>" alt="강의 썸네일">
                </div>
                <div class="p_box">
                  <p><?= $class_row['cl_title'] ?></p>
                  <p><?= $class_row['cl_teacher'] ?> &#x00B7; <?= $class_row['cl_category'] ?></p>
                  <p><?= substr($row['cm_datetime'], 0, 10) ?></p>
                </div>
                <p class="over">결제완료</p>
              </a>
            <?php }
            while ($rowCount < 2) { ?>
              <a href="#" title="결제 내역" class="sell_con no_data">데이터가 없습니다.</a>
              <?php $rowCount++;
            } ?>
          </article>

          <!-- 3. 새로 등록한 수강생 -->
          <article id="goal" style="padding: 0 15px">
            <h2 style="border-bottom:1px solid #ccc; padding: 15px 0">새로 등록한 수강생</h2>
            <a href="student_list.php" title="새로 등록한 수강생"><img src="./images/plus_white.svg" alt="더보기버튼"
                class="plus"></a>
            <div class="table">
              <table>
                <?php
                $sql = "WITH RecentMembers AS ( SELECT m.mb_photo, m.mb_nick, cm.cm_datetime, ROW_NUMBER() OVER (PARTITION BY m.mb_no ORDER BY cm.cm_datetime DESC) as rn FROM gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.mb_no = '$mb_no' AND cm.cm_status != 3 AND mb_level = 1 ) SELECT mb_photo, mb_nick, cm_datetime FROM RecentMembers WHERE rn = 1 ORDER BY cm_datetime DESC LIMIT 3;;";
                $result = mysqli_query($conn, $sql);
                $rowCount = 0;
                while ($row = mysqli_fetch_array($result)) {
                  $rowCount++;
                  ?>
                  <tr>
                    <td><img src="../guest/images/profile/<?= $row['mb_photo'] ?>" alt="임시이미지"></td>
                    <td><?= $row['mb_nick'] ?></td>
                    <td><?= substr($row['cm_datetime'], 0, 10) ?></td>
                  </tr>
                <?php }
                while ($rowCount < 3) {
                  ?>
                  <tr>
                    <td class="no_data">데이터가 없습니다.</td>
                  </tr>
                  <?php $rowCount++;
                } ?>
              </table>
            </div>
          </article>
        </div>

        <!-- 4. 나의 인기 클래스 -->
        <article id="new_class">
          <h2>나의 인기 클래스</h2>
          <a href="student_class.php" title="나의 클래스 목록"><img src="./images/plus_white.svg" alt="더보기버튼"
              class="plus"></a>

          <div class="flex_box">
            <?php
            $sql = "SELECT c.*
            FROM gl_class c
            INNER JOIN (
              SELECT cl_no, COUNT(*) AS order_count
              FROM gl_class_member
              WHERE cm_datetime BETWEEN NOW() - INTERVAL 7 DAY AND NOW()
              GROUP BY cl_no
              ORDER BY order_count DESC
            ) AS top_classes ON c.cl_no = top_classes.cl_no
            WHERE c.mb_no = '$mb_no'
              LIMIT 3;";
            $result = mysqli_query($conn, $sql);
            $rowCount = 0;
            while ($row = mysqli_fetch_array($result)) {
              $rowCount++;
              ?>
              <a href="./class_ad_view.php?cl_no=<?= $row['cl_no'] ?>" class="card">
                <img src="./images/class/<?= $row['cl_thumbnail'] ?>" alt="클래스 썸네일" class="thum">
                <div class="info">
                  <p><?= $row['cl_title'] ?></p>
                  <p><?= $row['cl_teacher'] ?> &#x00B7; <?= $row['cl_category'] ?></p>
                  <p><?= $row['cl_desc'] ?></p>
                  <p><?= $row['cl_time'] ?>분</p>
                  <p><?= $row['cl_start'] ?> ~ <?= $row['cl_end'] ?></p>
                </div>
              </a>
            <?php }
            while ($rowCount < 3) {
              $rowCount++;
              ?>
              <a href="" class="card no_data">
                <img src="../guest/images/out_of_stock.png" alt="내용없음">
                <p>데이터가 없습니다.</p>
              </a>
            <?php } ?>
          </div>

        </article>
      </section>

      <!-- 오른쪽 반 -->
      <section id="right">
        <h2 class="blind">크리에이터 메인페이지</h2>
        <!-- 1.공지사항 -->
        <article id="notice">
          <h2>공지사항</h2>
          <a href="notice_ad_list.php" title="공지사항"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>
          <div class="wrap2">
            <?php
            $sql = "SELECT * FROM gl_notice where cl_no IN(SELECT cl_no FROM gl_class where mb_no = $mb_no) order by no_no desc limit 5";
            $result = mysqli_query($conn, $sql);
            $rowCount = 0;
            while ($row = mysqli_fetch_array($result)) {
              $rowCount++;
              $cl_no = $row['cl_no'];
              $sql = "SELECT * FROM gl_class where cl_no = $cl_no";
              $class_result = mysqli_query($conn, $sql);
              $class_row = mysqli_fetch_array($class_result);
              ?>
              <a href="./notice_ad_upload.php?type=modify&no_no=<?= $row['no_no'] ?>" class="notice_list">
                <img src="./images/class/<?= $class_row['cl_thumbnail'] ?>" alt="클래스 썸네일" class="thum">
                <h4><?= $row['no_title'] ?></h4>
                <p><?= substr($row['no_datetime'], 0, 10) ?></p>
              </a>
            <?php }
            while ($rowCount < 5) { ?>
              <a href="" class="notice_list no_data">
                데이터가 없습니다.
              </a>
              <?php $rowCount++;
            } ?>
          </div>
        </article>

        <!-- 2. q&a -->
        <article id="qna">
          <h2>Q&A</h2>
          <a href="qna_ad_list.php" title="qna"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>
          <table>
            <?php
            $sql = "SELECT * from gl_qna where qna_parent_no is null AND cl_no IN(SELECT cl_no FROM gl_class where mb_no = $mb_no) order by qna_no desc limit 5";
            $result = mysqli_query($conn, $sql);
            $rowCount = 0;
            while ($row = mysqli_fetch_array($result)) {
              $rowCount++;
              $mb_no = $row["mb_no"];
              $sql = "select mb_nick from gl_member where mb_no = $mb_no";
              $mb_result = mysqli_query($conn, $sql);
              $mb = mysqli_fetch_array($mb_result);
              ?>
              <tr>
                <?php
                $parent_no = $row['qna_no'];
                $sql = "SELECT * from gl_qna where qna_parent_no = $parent_no";
                $parent_result = mysqli_query($conn, $sql);
                $parent = mysqli_fetch_array($parent_result);
                if ($parent) {
                  ?>
                  <td><a href="./qna_ad_upload.php?type=modify&qna_no=<?=$row['qna_no']?>" title="질문"><?= $row['qna_title'] ?></a>
                  </td>
                  <td><a href="./qna_ad_upload.php?type=modify&qna_no=<?=$row['qna_no']?>" title="질문자"><?= $mb['mb_nick'] ?></a></td>
                  <td><a href="./qna_ad_upload.php?type=modify&qna_no=<?=$row['qna_no']?>" title="날짜"><?= substr($row['qna_datetime'], 0, 10) ?></a></td>
                  <td class="status">
                    <a href="./qna_ad_upload.php?type=modify&qna_no=<?=$row['qna_no']?>" title="답변상태">
                      <p class="complete">답변완료</p>
                    </a>
                  </td>
                <?php } else { ?>
                  <td><a href="./qna_ad_upload.php?type=update&qna_no=<?=$row['qna_no']?>" title="질문"><?= $row['qna_title'] ?></a>
                  </td>
                  <td><a href="./qna_ad_upload.php?type=update&qna_no=<?=$row['qna_no']?>" title="질문자"><?= $mb['mb_nick'] ?></a></td>
                  <td><a href="./qna_ad_upload.php?type=update&qna_no=<?=$row['qna_no']?>" title="날짜"><?= substr($row['qna_datetime'], 0, 10) ?></a></td>
                  <td class="status">
                    <a href="./qna_ad_upload.php?type=update&qna_no=<?=$row['qna_no']?>" title="답변상태">
                      <p>답변대기</p>
                    </a>
                  </td>
                <?php } ?>
              </tr>
            <?php }
            while ($rowCount < 5) {
              ?>
              <tr>
                <td colspan="4" class="no_data">데이터가 없습니다.</td>
              </tr>
              <?php
              $rowCount++;
            }
            ?>
          </table>

        </article>

        <!-- 3. 새 클래스평가 -->
        <article id="new_review">
          <h2>새로 등록된 클래스 평가</h2>
          <a href="review_ad_list.php" title="클래스평가"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>
          <table>
            <?php
            $mb_no = $_SESSION['userno'];
            $sql = "SELECT * from gl_review where cl_no IN (SELECT cl_no FROM gl_class where mb_no = $mb_no) order by review_no desc limit 3;";
            $result = mysqli_query($conn, $sql);
            $rowCount = 0;
            while ($row = mysqli_fetch_array($result)) {
              $rowCount++;
              $cl_no = $row['cl_no'];
              $sql = "SELECT * from gl_class where cl_no = $cl_no";
              $cl_result = mysqli_query($conn, $sql);
              $cl = mysqli_fetch_array($cl_result);
              ?>
              <tr>
                <td><a href="./review_ad_view.php?rv_no=<?=$row['review_no']?>" title="리뷰 바로가기"><img src="./images/class/<?= $cl['cl_thumbnail'] ?>" alt="클래스썸네일"></a></td>
                <td><a href="./review_ad_view.php?rv_no=<?=$row['review_no']?>" title="리뷰상세"><?= $row['rv_content'] ?></a>
                </td>
                <td>
                  <div class="review_star">
                    <div class="star">
                      <img src="../guest/images/review_star_noneColor.svg" width=18 alt="별없음">
                      <img src="../guest/images/review_star_noneColor.svg" width=18 alt="별없음">
                      <img src="../guest/images/review_star_noneColor.svg" width=18 alt="별없음">
                      <img src="../guest/images/review_star_noneColor.svg" width=18 alt="별없음">
                      <img src="../guest/images/review_star_noneColor.svg" width=18 alt="별없음">
                    </div>
                    <div class="star" style="width:calc(<?= $row['rv_star'] ?>*20px)">
                      <img src="./images/review_star_admin.svg" width=18 alt="별있음">
                      <img src="./images/review_star_admin.svg" width=18 alt="별있음">
                      <img src="./images/review_star_admin.svg" width=18 alt="별있음">
                      <img src="./images/review_star_admin.svg" width=18 alt="별있음">
                      <img src="./images/review_star_admin.svg" width=18 alt="별있음">
                    </div>
                  </div>
                </td>
                <td>
                  <p><?= substr($row['rv_datetime'], 0, 10) ?></p>
                </td>
              </tr>
              <?php
            }
            while ($rowCount < 3) {
              ?>
              <tr>
                <td colspan="4" class="no_data">데이터가 없습니다.</td>
              </tr>
              <?php $rowCount++;
            } ?>
          </table>

        </article>

      </section>
    </div>
  </main>


  <script>
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');

    const today = moment();
    const date = [];
    // let i = 0; i < 7; i++
    for (let i = 14; i > 0; i--) {
      date.push(moment(today).subtract(i, 'days').format('MM-DD'));
    }

    //선형 그래프
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: date,
        datasets: [{
          label: '수강생',
          data: [512, 750, 300, 524, 268, 382, 526, 364, 785, 865, 654, 1465, 965, 1245],
          borderWidth: 1,
          backgroundColor: "rgb(229 , 69 , 76)", //포인트 색상
          borderColor: "rgb(229 , 69 , 76)", // 선색상
          borderWidth: '2' // 선두께
        }]
      },
      options: {
        maintainAspectRatio: false, //비율은 유지하고 크기조정
        plugins: {
          legend: { //상단 범례
            position: 'top', //위치조정
            align: 'end',
            labels: { // 세부조정
              boxWidth: 12, //박스크기
              padding: 30, //패딩
              // usePointStyle: true,
            }
          },
        },
        tooltips: {
          usePointStyle: true, //포인트 애니메이션
        },
        scales: {
          y: {
            beginAtZero: true,
            display: false
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  </script>
</body>

</html>