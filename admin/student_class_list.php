<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스별 수강생</title>
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <link rel="stylesheet" href="./css/header.css" type="text/css">
  <link rel="stylesheet" href="./css/member_list.css" type="text/css">
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<?php
include ("./php/dbconn.php");

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

$page_size = 10; // 한 페이지 게시글 갯수 설정
$page_list_size = 5; // 최대 페이지 번호 갯수 설정

$cl_no = $_GET['cl_no'];
//cl_no는 클래스 넘버
$no = $_GET['no'] ?? 0;
//no는 페이지 기준이 되는 게시글 카운트를 나타냄. 0부터 시작
$field = $_GET['field'] ?? "mb_name";
//field는 검색 옵션을 의미, 기본값 mb_name -> /mb_nick/mb_tel/mb_email 검색가능
$search_word = $_GET['search_word'] ?? "";
//search_word는 검색어

if ($search_word != "") {
  $add_query = " and m.$field like '%" . $search_word . "%'";
} else {
  $add_query = "";
} // 검색어가 있을 경우 추가할 쿼리문 작성

$query = "SELECT cm_no
FROM gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no 
LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.cl_no = '$cl_no' AND cm.cm_status != 3";
$query .= $add_query;
$query .= " ORDER BY cm.cm_no DESC LIMIT $no,1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$start_no = $row[0] ?? "0";

$query = "SELECT DISTINCT m.mb_photo, m.mb_name, m.mb_level, m.mb_nick, m.mb_tel, m.mb_email, m.reg_date, c.cl_no, cm.cm_no
FROM gl_member m
INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no
LEFT JOIN gl_class c ON cm.cl_no = c.cl_no
WHERE c.cl_no = '$cl_no'
  AND cm.cm_status != 3
  AND cm.cm_no <= '$start_no'
  AND mb_level = 1";
$query .= $add_query;
$query .= " order by cm.cm_no desc limit $page_size";
$result = mysqli_query($conn, $query);
// 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록

$sql = "SELECT DISTINCT count(*) from gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.cl_no = '$cl_no' AND cm.cm_status != 3 and m.$field like '%" . $search_word . "%'";
$result_count = mysqli_query($conn, $sql);
$result_row = mysqli_fetch_row($result_count);
$total_row = $result_row[0] ?? "";
// 검색 입력까지 고려하여 전체 레코드 갯수를 구한다.

if ($total_row <= 0)
  $total_row = 0;
$total_page = floor(($total_row - 1) / $page_size);
// total_row -1을 해주는 이유는 0부터 시작하기 때문
// page_size에 한 페이지에 나타낸ㄴ 게시글의 수를 초기화했기 때문에 page_size로 나누면 전체 페이지의 수를 구할 수 있다.
// floor함수는 소수점을 내림연산을 하는 함수이다.

$current_page = floor($no / $page_size);
//현재 페이지는 게시글 카운트에서 page_size로 나눠주면 된다.
?>


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
          <li><a href="student_class.php" title="클래스별 수강생" class="now_link">- 클래스별 수강생</a></li>
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
          <li><a href="qna_ad_list.php" title="QNA">- QNA</a></li>
        </ul>
      </li>
      <li><a href="review_ad_list.php" title="클래스평가 조회"><img src="./images/pencil_admin.svg" alt=""
            class="first_icon">클래스평가 조회</a></li>
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

  <!-- 상단 로그아웃/설정탭 -->
  <nav class="header2">
    <div class="btn_box">
      <a href="#" title="알림" class="bell"><img src="./images/bell_admin.svg" alt="종 아이콘"></a>
      <a href="./php/logout.php" title="로그아웃" class="logout_btn">로그아웃</a>
      <a href="" title="계정관리" class="setting_btn"><img src="./images/setting_admin.svg" alt="">계정관리</a>
    </div>
  </nav>
  <p class="branch">수강생조회 > 클래스별수강생</p>
  <main>
    <section>
      <h2>클래스별 수강생</h2>
      <div class="member_list_wrap">
        <!-- 검색폼 -->
        <form action="./student_list.php" name="search" method="get" class="member_search">
          <label for="field">검색범위</label>
          <select name="field" id="field">
            <option value="mb_name">이름 검색</option>
            <option value="mb_nick">닉네임 검색</option>
            <option value="mb_tel">전화번호 검색</option>
            <option value="mb_email">이메일 검색</option>
          </select>
          <label for="search_word">검색어</label>
          <input type="text" name="search_word" id="search_word" placeholder="검색어를 입력해 주세요.">
          <div class="submit_btn">
            <input type="submit" value="검색">
          </div>
        </form>

        <!-- 테이블 -->
        <table class="member_list">
          <caption>회원목록</caption>
          <thead>
            <tr>
              <th>이름</th>
              <th>등급</th>
              <th>닉네임</th>
              <th>휴대폰</th>
              <th>이메일</th>
              <th>가입일</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td>
                  <div class="member_profile_photo"><img src="../guest/images/profile/<?= $row[0] ?>" alt="프로필사진">
                  </div>
                  <?= $row[1] ?>
                </td>
                <td>
                  <!-- 회원등급별 분류 -->
                  <?php
                  $level = $row[2];
                  if ($level == 1) {
                    echo "학생";
                  } else if ($level == 2) {
                    echo "크리에이터";
                  } else {
                    echo "관리자";
                  }
                  ?>
                </td>
                <td><?= $row[3] ?></td>
                <td>
                  <?= preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $row[4]); ?>
                </td>
                <td><?= $row[5] ?></td>
                <td><?= substr($row[6], 0, 10) ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <!-- 페이지네이션 -->
        <div class="pagination">
          <?php
          $start_page = floor($current_page / $page_list_size) * $page_list_size;
          //현재 페이지에서 화면에 최대로 표시할 페이지 갯수인 page_list_size로 나눠서 floor함수로 내린다. 그 다음 다시 page_list_size로 곱해주게 되면 시작 페이지 번호를 구할 수 있다.
          
          $end_page = $start_page + $page_list_size - 1;
          if ($total_page < $end_page)
            $end_page = $total_page;
          // end_page는 start_page에서 page_list_size를 더한다음 1을 빼준다.
          // total_page가 end_page보다 작을 경우 end_page는 total_page가 된다.
          
          if ($start_page >= $page_list_size) {
            $prev_list = ($start_page - 1) * $page_size;
            echo "<a href=\"student_class_list.php?no=$prev_list&field=$field&search_word=$search_word&cl_no=$cl_no\"><img src='./images/prev_admin.svg'></a>";
          }
          // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 
          
          for ($i = $start_page; $i <= $end_page; $i++) {
            $page = $i * $page_size;
            $page_num = $i + 1; //0부터 시작하니 1을 더해준다.
          
            if ($no != $page) {
              echo "<a href=\"student_class_list.php?no=$page&field=$field&search_word=$search_word&cl_no=$cl_no\">" . $page_num . "</a>";
            } else {
              echo "<span class='current_page'>" . $page_num . "</span>";
            }
          }

          if ($total_page > $end_page) {
            $next_list = ($end_page + 1) * $page_size;
            echo "<a href=\"student_class_list.php?no=$next_list&field=$field&search_word=$search_word&cl_no=$cl_no\"><img src='./images/next_admin.svg'></a>";
          }
          //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
          ?>
        </div>
      </div>
    </section>
  </main>
  <script src="./script/header.js"></script>
  <script>
    $(document).ready(function () {
      $(".sub_menu").eq(0).show();
      $(".gnb > li > a").eq(0).addClass('active').find('.open').addClass('reverse');
      $(".gnb > li > a").eq(0).find('.first_icon').addClass('white')
    });
  </script>
</body>

</html>