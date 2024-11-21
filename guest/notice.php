<?php
include("./php/dbconn.php");
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 공지사항</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- notice.css -->
  <link rel="stylesheet" href="./css/notice.css" type="text/css">

</head>

<body>
  <?php
  $mb_no = $_SESSION["userno"];

  $sql = "select mb_level from gl_member where mb_no = '$mb_no'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $mb_level = $row[0]; //로그인한 사람의 mb_level;

  // 멤버 레벨별로 다르게 출력 쿼리 - 첫번째 게시글 찾는 쿼리
  if ($mb_level == 1) {
  } else if ($mb_level == 2) {
  } else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
    echo "<script>alert('로그인후 접근할 수 있습니다.');</script>";
    echo "<script>location.replace('./login.php');</script>";
  }

  $page_size = 5; // 한 페이지 게시글 갯수 설정
  $page_list_size = 5; // 최대 페이지 번호 갯수 설정


  $no = $_GET['no'] ?? 0;
  $cl_no = $_GET['cl_no'];
  //no는 페이지 기준이 되는 게시글 카운트를 나타냄. 0부터 시작

  $query = "SELECT no_no FROM gl_notice where cl_no='$cl_no' ORDER BY no_no DESC LIMIT $no,1";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_row($result);
  $start_no = $row[0] ?? "0";

  $add_query2 = "AND cl_no='$cl_no'";
  $query = "SELECT * from gl_notice where no_no<='$start_no'";
  $query .= $add_query2;
  $query .= " order by no_no desc limit $page_size";
  $result = mysqli_query($conn, $query);
  // 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록



  $query = "select count(*) from gl_notice where cl_no='$cl_no'";
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
  $mb_level = $_SESSION['userlevel']; ?>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php'); ?>
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>공지사항</p>
  </nav>
  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="notice">
      <h2 class="blind">공지사항</h2>
      <div class="wrap">
        <table class="notice_contents">
          <caption>공지사항</caption>
          <?php
          if (mysqli_num_rows($result) == 0) { ?>
            <div class="screen">
              <div class="no_info">
                <img src="./images/out_of_stock.png" alt="비어있음" class="empty">
                <p>작성된 글이 없습니다.</p>
                <?php
                if ($mb_level == '2') { ?>
                  <a href="notice_upload.php?cl_no=<?= $cl_no ?>" alt="글쓰기버튼" class="write_btn"><img src="./images/edit_white.svg" alt="공지작성">공지작성</a>
                <?php } else {
                  echo "";
                } ?>
              </div>
            </div>
            <?php } else {
            while ($row = mysqli_fetch_array($result)) { ?>
              <tr>
                <td>
                  <a href="./notice_view.php?no_no=<?php echo $row['no_no'] ?>"><?php echo $row['no_title'] ?>
                    <p class="notice_datetime"><?php echo substr($row['no_datetime'], 0, 10) ?></p>
                  </a>
                </td>
                <?php
                $mb_no = $row['mb_no'];
                $sql2 = "select mb_photo, mb_nick from gl_member where mb_no='$mb_no'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_array($result2); ?>
                <td>
                  <div class="notice_profile">
                    <img src="./images/profile/<?php echo $row2['mb_photo'] ?>" alt="프로필사진">
                    <p class="notice_usernick"><?php echo $row2['mb_nick'] ?></p>
                  </div>
                </td>
              </tr>
            <?php } ?>
        </table>
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
              echo "<a href=\"notice.php?no=$prev_list&cl_no=$cl_no\"><img src='./images/prev_admin.svg'></a>";
            }
            // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 

            for ($i = $start_page; $i <= $end_page; $i++) {
              $page = $i * $page_size;
              $page_num = $i + 1; //0부터 시작하니 1을 더해준다.

              if ($no != $page) {
                echo "<a href=\"notice.php?no=$page&cl_no=$cl_no\">" . $page_num . "</a>";
              } else {
                echo "<span class='current_page'>" . $page_num . "</span>";
              }
            }

            if ($total_page > $end_page) {
              $next_list = ($end_page + 1) * $page_size;
              echo "<a href=\"notice.php?no=$next_list&cl_no=$cl_no\"><img src='./images/next_admin.svg'></a>";
            }
            //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
        ?>
      </div>
    </section>
  </main>

  <div class="btn_box">
    <?php
            $sql3 = "SELECT cl_no FROM gl_notice WHERE cl_no = $cl_no";
            $result3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($result3);

            if ($mb_level == 2 && mysqli_num_rows($result3) > 0) { ?>

      <a href="notice_upload.php?cl_no=<?= $cl_no ?>" alt="글쓰기버튼" class="write_btn"><img src="./images/edit_white.svg" alt="공지작성"></a>
  <?php }
          } ?>
  </div>
  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>

</body>

</html>