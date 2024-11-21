<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 공지사항</title>
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <link rel="stylesheet" href="./css/header.css" type="text/css">
  <link rel="stylesheet" href="./css/notice_ad_list.css" type="text/css">
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

$page_size = 10; // 한 페이지 게시글 갯수 설정
$page_list_size = 5; // 최대 페이지 번호 갯수 설정


$no = $_GET['no'] ?? 0;
//no는 페이지 기준이 되는 게시글 카운트를 나타냄. 0부터 시작
$cl_no = $_GET['cl_no'] ?? "";
//cl_no 는 클래스 넘버

if ($mb_level == 2) {
  $query = "SELECT no_no FROM gl_notice where cl_no in (select cl_no from gl_class where mb_no = '$mb_no')";
  if($cl_no != ""){
    $query .= " AND cl_no = $cl_no";
  }
} else if ($mb_level == 3) {
  $query = "SELECT no_no FROM gl_notice";
  if($cl_no != ""){
    $query .= " WHERE cl_no = $cl_no";
  }
}
$query .= " ORDER BY no_no DESC LIMIT $no,1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$start_no = $row[0] ?? "0";

if ($cl_no != "") {
  $add_query = " and cl_no = '$cl_no'";
} else {
  $add_query = "";
} // 검색어가 있을 경우 추가할 쿼리문 작성

if ($mb_level == 2)
  $add_query2 = "AND cl_no in (select cl_no from gl_class where mb_no = '$mb_no')";
else if ($mb_level == 3)
  $add_query2 = "";

$query = "SELECT * from gl_notice where no_no<='$start_no'";
$query .= $add_query;
$query .= $add_query2;
$query .= " order by no_no desc limit $page_size";
$result = mysqli_query($conn, $query);
// 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록


$sql = "select count(*) from gl_notice WHERE 1=1";

if ($cl_no != "") {
  $sql .= " where cl_no = '$cl_no'";
} // 검색어가 있을 경우 추가할 쿼리문 작성
// 크리에이터일 경우 쿼리 추가
if ($mb_level == 2) {
  $sql .= " AND cl_no in (select cl_no from gl_class where mb_no = '$mb_no')";
} else if ($mb_level == 3) {
}
$result_count = mysqli_query($conn, $sql);
// 쿼리 결과 확인
if ($result_count) {
  $result_row = mysqli_fetch_row($result_count);
  $total_row = $result_row[0];
} else {
  // 오류 처리 코드 추가
  echo "쿼리 실행 오류: " . mysqli_error($conn);
}
$result_row = mysqli_fetch_row($result_count);
$total_row = $result_row[0];
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
            <li><a href="notice_ad_list.php" title="공지사항" class="now_link">- 공지사항</a></li>
            <li><a href="qna_ad_list.php" title="QNA">- QNA</a></li>
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
              <li><a href="notice_ad_list.php" title="공지사항" class="now_link">- 공지사항</a></li>
              <li><a href="qna_ad_list.php" title="QNA">- QNA</a></li>
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
  <p class="branch">게시판관리 > 공지사항</p>
  <main>
    <section>
      <h2>공지사항</h2>
      <div class="notice_wrap">
        <!-- 검색폼 -->
        <form name="search" method="get" class="notice_select">
          <label for="cl_no">강의명</label>
          <select name="cl_no" id="cl_no" required>
            <option value="" disabled selected>강의를 선택하세요</option>
            <?php
            if ($mb_level == 2) {
              $sql = "select * from gl_class where mb_no = '$mb_no' order by cl_title;";
            } else if ($mb_level == 3) {
              $sql = "select * from gl_class order by cl_title;";
            }
            $class_result = mysqli_query($conn, $sql);
            while ($class = mysqli_fetch_array($class_result)) {
              ?>
              <option value="<?= $class['cl_no'] ?>"><?= $class['cl_title'] ?></option>
              <?php
            }
            ?>
          </select>
          <input type="hidden" name="type" value="update">
          <input type="submit" value="이동하기" formaction="./notice_ad_list.php" class="notice_search_btn">
          <input type="submit" value="공지작성" formaction="./notice_ad_upload.php" class="notice_update_btn">
        </form>

        <!-- 테이블 -->
        <table class="notice_list">
          <caption>공지목록</caption>
          <thead>
            <tr>
              <th>번호</th>
              <th>제목</th>
              <th>작성자</th>
              <th>작성일</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td><?= $row['no_no'] ?></td>
                <td>
                  <?= $row['no_title'] ?>
                </td>
                <td>
                  <?php
                  $mb_no = $row['mb_no'];
                  $sql = "select mb_photo, mb_nick from gl_member where mb_no = '$mb_no'";
                  $member_result = mysqli_query($conn, $sql);
                  $member = mysqli_fetch_assoc($member_result);
                  ?>
                  <div class="member_profile_photo">
                    <img src="../guest/images/profile/<?= $member['mb_photo'] ?>" alt="프로필사진">
                  </div>
                  <?= $member['mb_nick'] ?>
                </td>
                <td><?= substr($row['no_datetime'], 0, 10) ?></td>
                <td>
                  <a href="./notice_ad_upload.php?type=modify&no_no=<?= $row['no_no'] ?>" title="공지수정"
                    class="notice_modify_btn">공지수정</a>
                  <a href="./php/notice_ad_delete.php?no_no=<?= $row['no_no'] ?>" onclick="return delete_check()"
                    class="notice_delete_btn">공지삭제</a>
                </td>
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
            echo "<a href=\"notice_ad_list.php?no=$prev_list&cl_no=$cl_no\"><img src='./images/prev_admin.svg'></a>";
          }
          // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 
          
          for ($i = $start_page; $i <= $end_page; $i++) {
            $page = $i * $page_size;
            $page_num = $i + 1; //0부터 시작하니 1을 더해준다.
          
            if ($no != $page) {
              echo "<a href=\"notice_ad_list.php?no=$page&cl_no=$cl_no\">" . $page_num . "</a>";
            } else {
              echo "<span class='current_page'>" . $page_num . "</span>";
            }
          }

          if ($total_page > $end_page) {
            $next_list = ($end_page + 1) * $page_size;
            echo "<a href=\"notice_ad_list.php?no=$next_list&cl_no=$cl_no\"><img src='./images/next_admin.svg'></a>";
          }
          //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
          ?>
        </div>
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

  <script>
    //삭제전 확인
    function delete_check() {
      if (confirm('정말로 삭제하시겠습니까?')) {
        return true;
      } else {
        return false;
      }
    };
  </script>
</body>

</html>