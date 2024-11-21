<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩 : 회원상세보기</title>

  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/member_list_view.css" />

  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- 학생멤버 뷰js -->
  <script src="./script/member_view_s.js"></script>
</head>

<body>

<?php include('./php/dbconn.php');

$mb_no = $_SESSION["userno"];

$sql = "select mb_level from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_level = $row[0]; //로그인한 사람의 mb_level;

// 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
if ($mb_level == 2) {
  echo "<script>alert('관리자 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
} else if ($mb_level == 3) {
} else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
  echo "<script>alert('관리자 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
}

?>

  <!-- 헤더 -->
  <?php include('./header.php');

  $mb_no = $_GET['mb_no'];
  $sql = "SELECT * FROM gl_member WHERE mb_no = '$mb_no'";
  $profile_result = mysqli_query($conn, $sql);
  $profile = mysqli_fetch_array($profile_result);

  ?>
  <!-- 브랜치 -->
  <p class="branch">회원관리 &#x003E; 회원상세</p>

  <main>
    <section id="center">
      <h2 class="blind">회원상세</h2>
      <!-- 프로필 -->
      <article id="profile">
        <h2>프로필</h2>

        <div class="flex_box">
          <div class="p_img">
            <img src="../guest/images/profile/<?= $profile['mb_photo'] ?>" alt="프로필사진">
          </div>

          <table class="p_con">
            <tr>
              <td>이름</td>
              <td><?php echo $profile['mb_name'] ?></td>
            </tr>
            <tr>
              <td>닉네임</td>
              <td><?php echo $profile['mb_nick'] ?></td>
            </tr>
            <tr>
              <td>이메일</td>
              <td><?php echo $profile['mb_email'] ?></td>
            </tr>
            <tr>
              <td>휴대폰</td>
              <td><?= preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $profile['mb_tel']); ?></td>
            </tr>
          </table>

          <table class="p_con">
            <tr>
              <td>관심사</td>
              <td>
                <?php
                $interest = $profile['mb_interest'];

                // 한 번의 str_replace 호출로 여러 개의 치환 수행
                $interestSTR = [
                  "cate01" => "보컬",
                  "cate02" => "힙합",
                  "cate03" => "뮤지컬/재즈/클래식",
                  "cate04" => "프로듀싱",
                  "cate05" => "작사/작곡",
                  "cate06" => "음향관리/엔지니어링",
                ];

                $modi_interest = str_replace(array_keys($interestSTR), array_values($interestSTR), $interest);

                echo $modi_interest ?></td>
            </tr>
            <tr>
              <td>가입입</td>
              <td><?php echo substr($profile['reg_date'], 0, 10) ?></td>
            </tr>
            <tr>
              <td>포인트</td>
              <td><?php echo $profile['mb_point'] ?></td>
            </tr>
            <tr>
              <td>등급</td>
              <td>
                <?php
                $level = $profile['mb_level'];

                $level_STR = [
                  "1" => "학생",
                  "2" => "크리에이터",
                  "3" => "관리자"
                ];

                $modi_level = str_replace(array_keys($level_STR), array_values($level_STR), $level);

                echo $modi_level ?></td>
            </tr>
          </table>
        </div>
      </article>

      <div class="flex_box" style="height:538px;">
        <!-- 수강중인 클래스 -->
        <article id="now_class">
          <h2>수강중인 클래스</h2>
          <a href="class_ad_ongoing.php?mb_no=<?= $mb_no ?>" title="진행중인 클래스">
            <img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>

          <?php
          $sql = "SELECT  gcm.cl_no, 
                          gcm.progress, 
                          gcm.cm_randate,
                          gcm.progress,
                          gc.cl_thumbnail, 
                          gc.cl_title, 
                          gc.cl_teacher, 
                          gc.cl_category, 
                          gc.cl_start, 
                          gc.cl_end
                  FROM gl_class_member AS gcm
                  INNER JOIN gl_class AS gc ON gcm.cl_no = gc.cl_no
                  WHERE gcm.mb_no = $mb_no
                  AND gcm.cm_status IN (1)
                  AND gc.cl_end > CURDATE()
                  ORDER BY gcm.cm_datetime DESC
                  LIMIT 1;";

          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);

          if (mysqli_num_rows($result) == 0) { ?>
            <div class='no_class'>
              <img src='./images/out_of_stock.png' alt='클래스 정보없음'>
              <p>수강중인 클래스가 없습니다.</p>
            </div>
          <?php
          } else {  ?>

            <a href='class_ad_view.php?cl_no=<?= $row['cl_no'] ?>' title='클래스' class='thum'>
              <img src='./images/class/<?= $row['cl_thumbnail'] ?>' alt='가장 최근 수강한 클래스' />
            </a>
            <a href=class_ad_view.php?mb_no=<?= $mb_no ?>'' title='클래스' class='info'>
              <h4><?= $row['cl_title'] ?></h4>
              <p><?= $row['cl_teacher'] ?> &#x00B7; <?= $row['cl_category'] ?></p>
              <p><?= $row['cl_start'] ?> ~ <?= $row['cl_end'] ?></p>
              <p>마지막 수강일 : <?= $row['cm_randate'] ?></p>
            </a>
            <!-- 차트 -->
            <div class="chart_box chart_box_one">
              <div class="chart" data-cl_no="<?= $row['cl_no']; ?>" data-mb_no="<?= $mb_no ?>"></div>
              <span><?= $row['progress'] ?>%</span>
            </div>
            <input type="hidden" value="<?= $row['cl_no'] ?>" class="cl_no">
            <input type="hidden" value="<?= $mb_no ?>" class="mb_no">
          <?php }
          ?>

        </article>


        <!-- 클래스이력 -->
        <article id="history">
          <h2>클래스 이력</h2>
          <a href="class_ad_closed.php?mb_no=<?= $mb_no ?>" title="클래스 이력"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>

          <?php
          $sql = "SELECT
          gcm.cl_no,
          gcm.progress,
          gcm.cm_randate,
          gcm.cm_status,
          gcm.progress,
          gc.cl_thumbnail,
          gc.cl_title,
          gc.cl_teacher,
          gc.cl_category,
          gc.cl_start,
          gc.cl_end
      FROM gl_class_member AS gcm
      INNER JOIN gl_class AS gc ON gcm.cl_no = gc.cl_no
      WHERE gcm.mb_no = $mb_no
      AND gcm.cm_status IN (2, 3)
      AND gc.cl_end < CURDATE()
      ORDER BY gcm.cm_randate DESC
      LIMIT 3;";

          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) == 0) { ?>
            <div class='no_class'>
              <img src='./images/out_of_stock.png' alt='클래스 정보없음'>
              <p>클래스 수강 이력이 없습니다.</p>
            </div>
            <?php
          } else {
            while ($row2 = mysqli_fetch_array($result)) { ?>
              <a href='class_ad_view.php?cl_no=<?= $row2['cl_no'] ?>' title='' class='h_con flex_box'>
                <div class='class'>
                  <img src='./images/class/<?= $row2['cl_thumbnail'] ?>' alt=''>
                </div>

                <div class='info'>
                  <h4><?= $row2['cl_title'] ?></h4>
                  <p><?= $row2['cl_teacher'] ?> &#x00B7; <?= $row2['cl_category'] ?></p>
                  <p><?= $row2['cl_start'] ?> ~ <?= $row2['cl_end'] ?></p>
                  <p>마지막 수강일 : <?= $row2['cm_randate'] ?></p>
                </div>

                <!-- 차트 -->
                <div class="chart_box">
                  <div class="chart" data-cl_no="<?= $row2['cl_no']; ?>" data-mb_no="<?= $mb_no ?>"></div>
                  <span><?= $row2['progress'] ?>%</span>
                </div>
                <input type="hidden" value="<?= $row2['cl_no'] ?>" class="cl_no">
                <input type="hidden" value="<?= $mb_no ?>" class="mb_no">

              </a>
          <?php }
          } ?>
        </article>
      </div>

      <!-- 리뷰 -->
      <article id="review">
        <h2>작성한 클래스평</h2>
        <a href="review_ad_list.php?mb_no=<?= $mb_no ?>" title="작성한 클래스평"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus" /></a>

        <div class='grid'>
          <?php

          $sql = "SELECT 
    r.mb_no, r.review_no, r.cl_no, r.rv_star, r.rv_content, r.rv_datetime,
    c.cl_thumbnail, c.cl_title, c.cl_category,c.cl_teacher
FROM gl_review AS r
INNER JOIN gl_class AS c ON r.cl_no = c.cl_no
WHERE r.mb_no = $mb_no
ORDER BY r.rv_datetime DESC
LIMIT 4;";

          $result = mysqli_query($conn, $sql);
          if (!$result) {
            echo "에러: " . mysqli_error($conn);
            exit;
          }
          $row = mysqli_fetch_array($result);

          if (empty($row)) {
            echo "<div class='no_class'>
          <img src='./images/out_of_stock.png' alt='정보없음' style='width: 100px;'>
          <p>등록한 클래스 평가가 없습니다.</p>
          </div>";
          } else {
            do {
              echo "
              <a href='review_ad_view.php?rv_no=" . $row['review_no'] . "' title='리뷰' class='flex_box item'>
                  <img src='./images/class/" . $row['cl_thumbnail'] . "' alt='' />
                  <div class='item_txt'>
                      <h4>" . $row['cl_title'] . "</h4>
                      <p style='margin-bottom: 3px;'>" . $row['cl_category'] . "</p>
                      <div class='star_box'>
                    <div class='review_star'>
                      <div class='star'>
                        <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                        <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                        <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                        <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                        <img src='../guest/images/review_star_noneColor.svg' width=13 alt='별없음'>
                      </div>
                      <div class='star star2' style='width:calc(" . $row['rv_star'] . "*13px)'>
                        <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                        <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                        <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                        <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                        <img src='./images/review_star_admin.svg' width=13 alt='별있음'>
                      </div>
                    </div>
                  <p class='date'>" . substr($row['rv_datetime'], 0, 10) . "</p></div>
                  <p class='con'>" . $row['rv_content'] . "</p>
                  </div>
                  </a>
                  
              ";
            } while ($row = mysqli_fetch_array($result));
          }
          ?>
        </div>
      </article>

      <div class="flex_box btn_center">
        <a href="member_list_upload.php?mb_no=<?= $mb_no ?>" title="회원수정" class="up_btn">회원수정</a>
        <a href="" title="회원탈퇴" class="del_btn">회원탈퇴</a>
      </div>
    </section>
  </main>

</body>

</html>