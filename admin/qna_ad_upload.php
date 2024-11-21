<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : <?= $title ?></title>
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <link rel="stylesheet" href="./css/header.css" type="text/css">
  <link rel="stylesheet" href="./css/qna_ad_upload.css" type="text/css">
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<?php
include ("./php/dbconn.php");

$mb_no = $_SESSION["userno"];

$sql = "select mb_level from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_level = $row[0]; //로그인한 사람의 mb_level;

// 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
if ($mb_level == 2) {
} else if ($mb_level == 3) {
} else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
  echo "<script>alert('관리자 아이디로 로그인해 주세요');</script>";
  echo "<script>location.replace('./login_ad.php');</script>";
}

$type = $_GET['type'];
$qna_no = $_GET['qna_no'];
$sql = "select * from gl_qna where qna_no = $qna_no";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($type == 'update') {
  $title = '답글 작성';
  $action = './php/qna_ad_update.php';
  $submit = '작성하기';
} else if ($type == 'modify') {
  $title = '답글 수정';
  $action = "./php/qna_ad_modify.php";
  $submit = '수정하기';
}
?>
  <!-- 멤버레벨에 따라 헤더 다르게 하기 -->
  <?php if ($mb_level == 2) { ?>
    <header>
      <!-- 메인로고 -->
      <h1>
        <a href="mypage_t.php" title="메인페이지"><img src="./images/logo_whiteColor.svg" alt="메인로고" /></a>
      </h1>
      <!-- <p class="menu">MENU</p> -->

      <!-- gnb -->
      <ul class="gnb">
        <li>
          <a href="#" title="수강생조회 탭"><img src="./images/cs_manager.svg" alt="회원아이콘" class="first_icon" />수강생조회<img
              src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" />
          </a>
          <ul class="sub_menu">
            <li><a href="student_list.php" title="전체수강생">- 전체수강생</a></li>
            <li><a href="student_class.php" title="클래스별 수강생">- 클래스별 수강생</a></li>
          </ul>
        </li>
        <li>
          <a href="#" title="클래스관리 탭"><img src="./images/class_admin.svg" alt="동영상아이콘" class="first_icon" />클래스관리<img
              src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
          <ul class="sub_menu">
            <li><a href="class_ad_list.php" title="전체클래스">- 전체클래스</a></li>
            <li><a href="class_ad_ongoing.php" title="진행클래스">- 진행클래스</a></li>
            <li><a href="class_ad_closed.php" title="종료클래스">- 종료클래스</a></li>
          </ul>
        </li>
        <li>
          <a href="#" title="게시판관리 탭"><img src="./images/board_admin.svg" alt="게시판아이콘" class="first_icon" />게시판관리<img
              src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
          <ul class="sub_menu">
            <li><a href="notice_ad_list.php" title="공지사항">- 공지사항</a></li>
            <li><a href="qna_ad_list.php" title="QNA" class="now_link">- QNA</a></li>
          </ul>
        </li>
        <li><a href="review_ad_list.php" title="클래스평가 조회"><img src="./images/pencil_admin.svg" alt=""
              class="first_icon">클래스평가 조회</a></li>
      </ul>

      <!-- 수정한 부분 -->
      <!-- 프로필 -->
      <div class="profile">

        <div class="psa">
          <?php
          $mb_no = $_SESSION['userno'];
          $sql = "select * from gl_member where mb_no = '$mb_no'";
          $profile_result = mysqli_query($conn, $sql);
          $profile = mysqli_fetch_array($profile_result);
          ?>
          <img src="../guest/images/profile/<?= $profile['mb_photo'] ?>" alt="프로필사진">
        </div>

        <strong><?= $profile['mb_nick'] ?>(<?= $profile['mb_id'] ?>)</strong>

        <table>
          <tr>
            <th>등급</th>
            <td colspan="2">
              <?php
              $level = $profile['mb_level'];
              if ($level == 2) {
                echo "크리에이터";
              } else {
                echo "관리자";
              }
              ?>
            </td>
          </tr>

          <tr>
            <th>진행클래스</th>
            <?php
            $sql = "SELECT COUNT(*) FROM gl_class WHERE cl_end >= CURDATE() and cl_start <= CURDATE() and mb_no = '$mb_no';";
            $count_result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_array($count_result);
            $cl_count = $count[0];
            ?>
            <td> <?= $cl_count ?> 개</td>
            <td><a href="student_class.php" title="전체클래스">관리</a></td>
          </tr>

          <tr>
            <th>신규게시글</th>
            <?php
            $sql = "SELECT COUNT(*) FROM gl_qna WHERE qna_datetime > NOW() - INTERVAL 1 DAY
      AND cl_no IN (SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
            $count_result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_array($count_result);
            $qna_count = $count[0];
            $sql = "SELECT COUNT(*) FROM gl_notice WHERE no_datetime > NOW() - INTERVAL 1 DAY
      AND cl_no IN (SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
            $count_result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_array($count_result);
            $qna_count = $count[0];
            ?>
            <td> <?= $qna_count ?> 건</td>
            <td><a href="notice_ad_list.php" title="공지사항">관리</a></td>
          </tr>

          <tr>
            <th>신규수강생</th>
            <?php
            $sql = "SELECT COUNT(DISTINCT mb_no) FROM gl_class_member WHERE cm_datetime > NOW() - INTERVAL 1 DAY AND cl_no IN(SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
            $count_result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_array($count_result);
            $new_student_count = $count[0];
            ?>
            <td> <?= $new_student_count ?> 명</td>
            <td><a href="student_list.php" title="전체수강생">관리</a></td>
          </tr>

          <tr>
            <th>수강생</th>
            <?php
            $sql = "SELECT COUNT(DISTINCT mb_no) FROM gl_class_member WHERE cl_no IN(SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
            $count_result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_array($count_result);
            $student_count = $count[0];
            ?>
            <td> <?= $student_count ?> 명</td>
            <td><a href="student_list.php" title="전체수강생">관리</a></td>
          </tr>

        </table>
      </div>


    </header>
  <?php } else if ($mb_level == 3) { ?>
      <header>
        <!-- 메인로고 -->
        <h1>
          <a href="mypage_ad.php" title="메인페이지"><img src="./images/logo_whiteColor.svg" alt="메인로고" /></a>
        </h1>
        <!-- <p class="menu">MENU</p> -->

        <!-- gnb -->
        <ul class="gnb">
          <li>
            <a href="#" title="회원관리 탭"><img src="./images/cs_manager.svg" alt="회원아이콘" class="first_icon" />회원관리<img
                src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" />
            </a>
            <ul class="sub_menu">
              <li><a href="member_list.php" title="전체회원">- 전체회원</a></li>
              <li><a href="member_creator.php" title="크리에이터">- 크리에이터</a></li>
              <li><a href="member_student.php" title="학생회원">- 학생회원</a></li>
            </ul>
          </li>
          <li>
            <a href="#" title="클래스관리 탭"><img src="./images/class_admin.svg" alt="동영상아이콘" class="first_icon" />클래스관리<img
                src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
            <ul class="sub_menu">
              <li><a href="class_ad_list.php" title="전체클래스">- 전체클래스</a></li>
              <li><a href="class_ad_ongoing.php" title="진행클래스">- 진행클래스</a></li>
              <li><a href="class_ad_closed.php" title="종료클래스">- 종료클래스</a></li>
              <li><a href="class_ad_upload.php" title="클래스등록">- 클래스등록</a></li>
              <li><a href="review_ad_list.php" title="클래스평가">- 클래스평가</a></li>
            </ul>
          </li>
          <li>
            <a href="#" title="게시판관리 탭"><img src="./images/board_admin.svg" alt="게시판아이콘" class="first_icon" />게시판관리<img
                src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
            <ul class="sub_menu">
              <li><a href="notice_ad_list.php" title="공지사항">- 공지사항</a></li>
              <li><a href="qna_ad_list.php" title="QNA" class="now_link">- QNA</a></li>
            </ul>
          </li>
          <li>
            <a href="#" title="스토어 탭"><img src="./images/store_admin.svg" alt="가게모양아이콘" class="first_icon" />스토어<img
                src="./images/arrow_down_white.svg" alt="메뉴열기" class="open" /></a>
            <ul class="sub_menu">
              <li><a href="#" title="결제관리">- 결제관리</a></li>
              <li><a href="#" title="내역조회">- 내역조회</a></li>
              <li><a href="#" title="문의">- 문의</a></li>
            </ul>
          </li>
        </ul>

        <!-- 프로필 -->
        <div class="profile">

          <div class="psa">

            <?php
            $mb_no = $_SESSION['userno'];
            $sql = "select * from gl_member where mb_no = '$mb_no'";
            $profile_result = mysqli_query($conn, $sql);
            $profile = mysqli_fetch_array($profile_result);
            ?>
            <img src="../guest/images/profile/<?= $profile['mb_photo'] ?>" alt="프로필사진">
          </div>

          <strong><?= $profile['mb_nick'] ?>(<?= $profile['mb_id'] ?>)</strong>

          <table>
            <tr>
              <th>등급</th>
              <td colspan="2">
                <?php
                $level = $profile['mb_level'];
                if ($level == 2) {
                  echo "크리에이터";
                } else {
                  echo "관리자";
                }
                ?>
              </td>
            </tr>

            </tr>

            <tr>
              <th>진행클래스</th>
              <?php
              $sql = "SELECT COUNT(*) FROM gl_class WHERE cl_end >= CURDATE() and cl_start <= CURDATE();";
              $count_result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_array($count_result);
              $cl_count = $count[0];
              ?>
              <td> <?= $cl_count ?> 개</td>
              <td><a href="class_ad_list.php" title="전체클래스">관리</a></td>
            </tr>

            <tr>
              <th>신규게시글</th>
              <?php
              $sql = "SELECT COUNT(*) FROM gl_qna WHERE qna_datetime > NOW() - INTERVAL 1 DAY";
              $count_result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_array($count_result);
              $qna_count = $count[0];
              $sql = "SELECT COUNT(*) FROM gl_notice WHERE no_datetime > NOW() - INTERVAL 1 DAY";
              $count_result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_array($count_result);
              $qna_count += $count[0];
              ?>
              <td> <?= $qna_count ?> 건</td>
              <td><a href="notice_ad_list.php" title="공지사항">관리</a></td>
            </tr>

            <tr>
              <th>신규회원</th>
              <?php
              $sql = "SELECT COUNT(*) FROM gl_member WHERE reg_date > NOW() - INTERVAL 1 DAY";
              $count_result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_array($count_result);
              $new_user_count = $count[0];
              ?>
              <td> <?= $new_user_count ?> 명</td>
              <td><a href="member_list.php" title="전체회원">관리</a></td>
            </tr>

            <tr>
              <th>회원수</th>
              <?php
              $sql = "SELECT COUNT(*) FROM gl_member";
              $count_result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_array($count_result);
              $user_count = $count[0];
              ?>
              <td> <?= $user_count ?> 명</td>
              <td><a href="member_list.php" title="전체회원">관리</a></td>
            </tr>

          </table>
        </div>


      </header>
  <?php } ?>
  <!-- 상단 로그아웃/설정탭 -->
  <nav class="header2">
    <div class="btn_box">
      <a href="#" title="알림" class="bell"><img src="./images/bell_admin.svg" alt="종 아이콘"></a>
      <a href="./php/logout.php" title="로그아웃" class="logout_btn">로그아웃</a>
      <a href="" title="계정관리" class="setting_btn"><img src="./images/setting_admin.svg" alt="">계정관리</a>
    </div>
  </nav>
  <p class="branch">게시판관리 > QNA > <?= $title ?></p>
  <main>
    <section>
      <h2><?= $title ?></h2>
      <div class="qna_wrap">
        <form action="<?= $action ?>" name="notice" method="post">
          <p>
            <label for="qna_title">제목</label>
            <input type="text" name="qna_title" id="qna_title" value="<?= $row['qna_title'] ?>" readonly>
          </p>
          <p>
            <?php
            $no_w_no = $row['mb_no'];
            $sql = "SELECT mb_nick from gl_member where mb_no = $no_w_no";
            $writer_result = mysqli_query($conn, $sql);
            $writer = mysqli_fetch_array($writer_result);
            ?>
            <label for="writer">작성자</label>
            <input type="text" name="writer" id="writer" value="<?= $writer[0] ?>" readonly>
          </p>
          <p>
            <?php
            $no_cl_no = $row['cl_no'];
            $sql = "SELECT cl_title from gl_class where cl_no = $no_cl_no";
            $class_result = mysqli_query($conn, $sql);
            $class = mysqli_fetch_array($class_result);
            ?>
            <label for="class">강의명</label>
            <input type="hidden" name="cl_no" id="cl_no" value="<?= $no_cl_no ?>">
            <input type="text" name="class" id="class" value="<?= $class[0] ?>" readonly>
          </p>
          <p>
            <input type="hidden" name="qna_no" value="<?= $qna_no ?>">
            <label for="qna_datetime">작성일</label>
            <input type="text" name="qna_datetime" id="qna_datetime" value="<?= substr($row['qna_datetime'], 0, 10) ?>"
              readonly>
          </p>
          <p>
          <div class="qna_content">
            <?php if ($row['qna_image'] != ""): ?>
              <img src="../guest/images/qna/<?= $row['qna_image'] ?>" alt="질문사진"><br>
            <?php endif; ?>
            <?= nl2br($row['qna_content']) ?>
          </div>
          </p>
          <p>
            <label for="qna_reply">답변내용</label>
            <textarea name="qna_reply" id="qna_reply" cols="30" rows="10" placeholder="답변을 작성해주세요."><?php
            $sql = "select qna_content, qna_no from gl_qna where qna_parent_no = '$qna_no'";
            $parent_result = mysqli_query($conn, $sql);
            $parent_row = mysqli_fetch_array($parent_result);
            echo $parent_row["0"] ?? "";
            ?></textarea>
            <input type="hidden" name="qna_answer_no" value="<?= $parent_row['1'] ?>">
          </p>
          <p class="notice_buttons">
            <input type="submit" value="<?= $submit ?>" class="notice_submit_btn">
            <a href="javascript:window.history.back();" class="notice_cancel_btn">취소하기</a>
          </p>
        </form>
      </div>
    </section>
  </main>
  <script src="./script/header.js"></script>
  <!-- 멤버레벨에 따라 펼쳐지는 gnb 다르게 하기 -->
  <script>
    $(document).ready(function () {
      $(".sub_menu").eq(2).show();
      $(".gnb > li > a").eq(2).addClass('active').find('.open').addClass('reverse');
      $(".gnb > li > a").eq(2).find('.first_icon').addClass('white')
    });
  </script>

</body>

</html>