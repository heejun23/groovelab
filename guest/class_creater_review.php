<?php
include("./php/dbconn.php");

$mb_no = $_SESSION["userno"];

$sql = "select mb_level from gl_member where mb_no = '$mb_no'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$mb_level = $row[0]; //로그인한 사람의 mb_level;

// 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
if ($mb_level == 1) {
  //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
  echo "<script>alert('학생회원은 접근할 수 있습니다.');</script>";
  echo "<script>history.back();</script>";
}

$page_size = 6; // 한 페이지 게시글 갯수 설정
$page_list_size = 5; // 최대 페이지 번호 갯수 설정


$no = $_GET['no'] ?? 0;
//no는 페이지 기준이 되는 게시글 카운트를 나타냄. 0부터 시작
//cl_no 는 클래스 넘버
$mb_no = $_SESSION['userno'];

$query = "SELECT review_no FROM gl_review where cl_no in (select cl_no from gl_class where mb_no = '$mb_no') ORDER BY review_no DESC LIMIT $no,1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$start_no = $row[0] ?? "0";

$add_query2 = "AND cl_no in (select cl_no from gl_class where mb_no = '$mb_no')";

$query = "SELECT * from gl_review where review_no<='$start_no'";
$query .= $add_query2;
$query .= " order by review_no desc limit $page_size";
$result = mysqli_query($conn, $query);
// 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록



$query = "select count(*) from gl_review where cl_no in (select cl_no from gl_class where mb_no = '$mb_no')";
$result_count = mysqli_query($conn, $query);
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

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스평가</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- login.php 스타일 시트 -->
  <link rel="stylesheet" href="./css/review_mypage.css" type="text/css">

</head>

<body>
  <!-- 헤더 -->
  <?php include('./header_m.php') ?>
  <!-- 하단 메뉴바 -->
  <?php include('./bottom_gnb.php') ?>
  <!-- 헤드 -->
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>클래스 평가</p>
  </nav>


  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="review_mypage">
      <h2 class="blind">QNA질문</h2>
      <div class="review_mypage_wrap">
        <?php
        while ($row = mysqli_fetch_array($result)) {
          // 해당강의 썸네일 사진 
          $cl_no = $row['cl_no'];
          $sql2 = "select cl_thumbnail, cl_title, cl_category from gl_class where cl_no='$cl_no'";
          $result2 = mysqli_query($conn, $sql2);
          $class = mysqli_fetch_array($result2);

          $cm_no = $row['cm_no'];
          $sql3 = "select * from gl_review where cm_no='$cm_no'";
          $result3 = mysqli_query($conn, $sql3);
          $row3 = mysqli_fetch_array($result3);
        ?>
          <a href="./review_view.php?review_no=<?php echo $row3['review_no'] ?>" class="review_mypage_box">
            <div class="review_mypage_img">
              <img src="../admin/images/class/<?php echo $class['cl_thumbnail'] ?>" alt="썸네일">
            </div>

            <div class="review_mypage_title">
              <h3><?php echo $class['cl_title'] ?></h3>
              <p class="cate"><?php echo $class['cl_category'] ?></p>
              <div class="star">
                <div class="review_star">
                  <!-- 색이없음 -->
                  <img src="./images/review_star_noneColor.svg" alt="별">
                  <img src="./images/review_star_noneColor.svg" alt="별">
                  <img src="./images/review_star_noneColor.svg" alt="별">
                  <img src="./images/review_star_noneColor.svg" alt="별">
                  <img src="./images/review_star_noneColor.svg" alt="별">
                </div>
                <div class="review_star" style="width:calc(<?php echo $row3['rv_star'] ?>*25px);">
                  <!-- 색이 있음 -->
                  <img src="./images/review_star_mainColor.svg" alt="별">
                  <img src="./images/review_star_mainColor.svg" alt="별">
                  <img src="./images/review_star_mainColor.svg" alt="별">
                  <img src="./images/review_star_mainColor.svg" alt="별">
                  <img src="./images/review_star_mainColor.svg" alt="별">
                </div>
              </div>
              <div class="review_date_nick">
                <p><?php echo substr($row3['rv_datetime'], 0, 10) ?></p>
                <?php
                $mb_no = $row3['mb_no'];
                $mb_nick = "select mb_nick from gl_member where mb_no='$mb_no'";
                $mb_result = mysqli_query($conn, $mb_nick);
                $mnick = mysqli_fetch_array($mb_result);
                ?>
                <p><?php echo $mnick['mb_nick'] ?></p>
              </div>
            </div>
          </a>
        <?php } ?>
      </div>

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
          echo "<a href=\"class_creater_review.php?no=$prev_list&cl_no=$cl_no\"><img src='./images/prev_admin.svg'></a>";
        }
        // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 

        for ($i = $start_page; $i <= $end_page; $i++) {
          $page = $i * $page_size;
          $page_num = $i + 1; //0부터 시작하니 1을 더해준다.

          if ($no != $page) {
            echo "<a href=\"class_creater_review.php?no=$page&cl_no=$cl_no\">" . $page_num . "</a>";
          } else {
            echo "<span class='current_page'>" . $page_num . "</span>";
          }
        }

        if ($total_page > $end_page) {
          $next_list = ($end_page + 1) * $page_size;
          echo "<a href=\"class_creater_review.php?no=$next_list&cl_no=$cl_no\"><img src='./images/next_admin.svg'></a>";
        }
        //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
        ?>
      </div>
    </section>
  </main>

  <!-- 제이쿼리 cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</body>

</html>