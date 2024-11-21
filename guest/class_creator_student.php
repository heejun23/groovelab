<?php
include("./php/dbconn.php");
?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 수강생 관리</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- notice.css -->
  <link rel="stylesheet" href="./css/class_creater_student.css" type="text/css">

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
    echo "<script>alert('잘못된 접근입니다.');</script>";
    echo "<script>location.replace('./login_start.php');</script>";
  } else if ($mb_level == 2) {
  } else { //강사, 관리자, 로그인 안되어 있을시 관리자 로그인 화면으로
    echo "<script>alert('로그인후 접근할 수 있습니다.');</script>";
    echo "<script>location.replace('./login_start.php');</script>";
  }

  $page_size = 5; // 한 페이지 게시글 갯수 설정
  $page_list_size = 5; // 최대 페이지 번호 갯수 설정


  $no = $_GET['no'] ?? 0;
  //no는 페이지 기준이 되는 게시글 카운트를 나타냄. 0부터 시작



  $query = "WITH RankedMembers AS ( SELECT cm.cm_no, m.mb_name, m.mb_nick, m.mb_tel, m.mb_email, ROW_NUMBER() OVER (PARTITION BY m.mb_no ORDER BY cm.cm_no DESC) AS rn FROM gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.mb_no = '$mb_no' AND cm.cm_status != 3 AND m.mb_level = 1 ) SELECT cm_no FROM RankedMembers where rn=1 ORDER BY cm_no DESC limit $no, 1";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_row($result);
  $start_no = $row[0] ?? "0";

  $query = "WITH RankedMembers AS ( SELECT m.mb_photo, m.mb_name, m.mb_level, m.mb_nick, m.mb_tel, m.mb_email, m.reg_date, c.cl_no, c.cl_thumbnail, cm.cm_no, ROW_NUMBER() OVER (PARTITION BY m.mb_no ORDER BY cm.cm_no DESC) AS rn FROM gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.mb_no = '$mb_no' AND cm.cm_status != 3 AND m.mb_level = 1 ) SELECT mb_photo, mb_name, mb_level, mb_nick, mb_tel, mb_email, reg_date, cl_thumbnail FROM RankedMembers WHERE rn = 1 AND cm_no <= '$start_no'";
  $query .= " ORDER BY cm_no DESC limit $page_size";
  $result = mysqli_query($conn, $query);
  // 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록



  $query = "WITH RankedMembers AS ( SELECT cm.cm_no, m.mb_name, m.mb_nick, m.mb_tel, m.mb_email, ROW_NUMBER() OVER (PARTITION BY m.mb_no ORDER BY cm.cm_no DESC) AS rn FROM gl_member m INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no LEFT JOIN gl_class c ON cm.cl_no = c.cl_no WHERE c.mb_no = '$mb_no' AND cm.cm_status != 3 AND m.mb_level = 1 ) SELECT count(*) FROM RankedMembers where rn=1";
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
    <p>수강생 관리</p>
  </nav>
  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="class_creater_student">
      <h2 class="blind">수강생 관리</h2>
      <div class="wrap">
        <table class="class_creater_student_contents">
          <caption>수강생 관리</caption>
          <?php
          if (mysqli_num_rows($result) == 0) { ?>
            <tr>
              <td class="no_bottom">
                <div class="screen">
                  <div class="no_info">
                    <img src="./images/out_of_stock.png" alt="비어있음" class="empty">
                    <p>수강생이 없습니다.</p>
                  </div>
                </div>
              </td>
            </tr>
          <?php } else {
          ?>
            <thead>
              <tr>
                <th>수강 클래스</th>
                <th>이름</th>
                <th>닉네임</th>
              </tr>
            </thead>
            <?php
            while ($row = mysqli_fetch_array($result)) { ?>
              <tr>
                <td>
                  <p class="class_creater_student_class_photo"><img src="../admin/images/class/<?php echo $row['cl_thumbnail'] ?>" alt=""></p>
                </td>
                <td>
                  <div class="class_creater_student_profile">
                    <img src="./images/profile/<?php echo $row['mb_photo'] ?>" alt="프로필사진">
                    <p class="class_creater_student_username"><?php echo $row['mb_name'] ?></p>
                  </div>
                </td>
                <td>
                  <p class="class_creater_student_usernick"><?= $row['mb_nick'] ?></p>
                </td>
              </tr>
            <?php } ?>

          <?php
          } ?>
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
          echo "<a href=\"class_creator_student.php?no=$prev_list\"><img src='./images/prev_admin.svg'></a>";
        }
        // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 

        for ($i = $start_page; $i <= $end_page; $i++) {
          $page = $i * $page_size;
          $page_num = $i + 1; //0부터 시작하니 1을 더해준다.

          if ($no != $page) {
            echo "<a href=\"class_creator_student.php?no=$page\">" . $page_num . "</a>";
          } else {
            echo "<span class='current_page'>" . $page_num . "</span>";
          }
        }

        if ($total_page > $end_page) {
          $next_list = ($end_page + 1) * $page_size;
          echo "<a href=\"class_creator_student.php?no=$next_list\"><img src='./images/next_admin.svg'></a>";
        }
        //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
        ?>
      </div>
    </section>
  </main>

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>

</body>

</html>