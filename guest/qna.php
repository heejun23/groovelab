<?php
include("./php/dbconn.php");
$page_size = 5; // 한 페이지 게시글 갯수 설정
$page_list_size = 5; // 최대 페이지 번호 갯수 설정

$no = $_GET['no'] ?? 0;
$cl_no = $_GET['cl_no'];

// $query = "SELECT qna_no FROM gl_qna where cl_no='$cl_no' AND qna_parent_no IS NULL ORDER BY qna_no DESC LIMIT $no,1";
$query = "SELECT qna_no FROM gl_qna WHERE cl_no='$cl_no' AND qna_parent_no IS NULL ORDER BY qna_no DESC LIMIT $no,1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$start_no = $row[0] ?? "";


// $query = "SELECT * from gl_qna where qna_no<='$start_no' AND qna_parent_no IS NULL AND cl_no ='$cl_no'";
$query = "SELECT * from gl_qna where qna_no<='$start_no' AND cl_no='$cl_no' AND qna_parent_no IS NULL";
$query .= " order by qna_no desc limit $page_size";
$result = mysqli_query($conn, $query);
// 검색 입력까지 고려하여 한 페이지 게시글 갯수만큼 mb_no를 기준으로 내림차순한 글 목록

// $sql = "SELECT count(*) from gl_qna WHERE cl_no AND qna_parent_no IS NULL";
$sql = "SELECT count(*) from gl_qna where cl_no = '$cl_no' AND qna_parent_no IS NULL";
$result_count = mysqli_query($conn, $sql);
$result_row = mysqli_fetch_row($result_count);
$total_row = $result_row[0];
// 검색 입력까지 고려하여 전체 레코드 갯수를 구한다.


if ($total_row <= 0)
  $total_row = 0;
$total_page = floor(($total_row - 1) / $page_size);

$current_page = floor($no / $page_size);
//현재 페이지는 게시글 카운트에서 page_size로 나눠주면 된다.

$mb_level = $_SESSION['userlevel'];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : QNA</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 서식 -->
  <link rel="stylesheet" href="./css/reset.css" type="text/css">
  <!-- qna.css -->
  <link rel="stylesheet" href="./css/qna.css" type="text/css">

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>
  <?php include('./header_m.php') ?>
  <?php include('./bottom_gnb.php'); ?>
  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>QNA</p>
  </nav>

  <!-- 메인콘텐츠 영역 -->
  <main>
    <section class="qna">
      <h2 class="blind">QNA질문</h2>
      <div class="qna_ajax_tab">
        <a href="./qna.php?cl_no=<?= $cl_no ?>" class="qna_tab_on">전체</a>
        <a href="./qna_wait.php?cl_no=<?= $cl_no ?>">답변대기</a>
        <a href="./qna_done.php?cl_no=<?= $cl_no ?>">답변완료</a>
      </div>
      <div class="big_box">
        <div class="qna_table_wrap">
          <table class="qna_contents">
            <caption>qna 게시판</caption>
            <?php
            if (mysqli_num_rows($result) == 0) { ?>
              <div class="screen">
                <div class="no_info">
                  <img src="./images/out_of_stock.png" alt="비어있음" class="empty">
                  <p>작성된 글이 없습니다.</p>
                  <?php
                  if ($mb_level == '1') { ?>
                    <a href="qna_upload.php?cl_no=<?= $cl_no ?>" title="글쓰기버튼" class="write_btn"><img src="./images/edit_white.svg" alt="질문하기">질문하기</a>
                  <?php } else {
                    echo "";
                  } ?>
                </div>
              </div>
              <?php } else {
              while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                  <td>
                    <?php
                    if (empty($row['qna_image'])) { ?>
                      <a href="qna_view.php?qna_no=<?php echo $row['qna_no'] ?>" class="qna_title"><?php echo $row['qna_title']; ?></a>
                    <?php } else { ?>
                      <a href="qna_view.php?qna_no=<?php echo $row['qna_no'] ?>" class="qna_title"><?php echo $row['qna_title']; ?><img src="./images/file_upload_white.svg" alt="이미지파일"></a>
                    <?php
                    }
                    ?>
                    <div class="qna_profile_wrap">
                      <?php
                      $mb_no = $row['mb_no'];
                      $sql3 = "select mb_photo, mb_nick from gl_member where mb_no='$mb_no'";
                      $result3 = mysqli_query($conn, $sql3);
                      $mb = mysqli_fetch_array($result3);
                      ?>
                      <div class="qna_profile_box">
                        <img src="./images/profile/<?= $mb['mb_photo'] ?>" alt="프로필사진">
                      </div>
                      <p class="qna_usernick"><?php echo $mb['mb_nick'] ?></p>
                      <p class="qna_datetime"><?php echo substr($row['qna_datetime'], 0, 10) ?></p>
                    </div>
                  </td>
                  <?php
                  $qna_no = $row['qna_no'];
                  $sql4 = "select * from gl_qna where qna_parent_no='$qna_no'";
                  $result4 = mysqli_query($conn, $sql4);
                  $row4 = mysqli_fetch_assoc($result4);
                  if ($row4) { ?> <!--답변이 있다면-->
                    <td class="qna_status_done">
                      <p>답변완료</p>
                    </td>
                  <?php } else { ?>
                    <td class="qna_status_wait">
                      <p>답변대기</p>
                    </td>
                  <?php } ?>
                </tr>
            <?php }
            } ?>
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
              echo "<a href=\"qna.php?no=$prev_list&cl_no=$cl_no\"><img src='./images/prev_admin.svg' alt='이전버튼'></a>";
            }
            // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 

            for ($i = $start_page; $i <= $end_page; $i++) {
              $page = $i * $page_size;
              $page_num = $i + 1; //0부터 시작하니 1을 더해준다.

              if ($no != $page) {
                echo "<a href=\"qna.php?no=$page&cl_no=$cl_no\">" . $page_num . "</a>";
              } else {
                echo "<span class='current_page'>" . $page_num . "</span>";
              }
            }

            if ($total_page > $end_page) {
              $next_list = ($end_page + 1) * $page_size;
              echo "<a href=\"qna.php?no=$next_list&cl_no=$cl_no\"><img src='./images/next_admin.svg' alt='다음버튼'></a>";
            }
            //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
            ?>
          </div>
        </div>
      </div> <!-- big_box -->
    </section>
  </main>
  <div class="btn_box">

    <?php
    $sql5 = "SELECT cl_no FROM gl_qna WHERE cl_no = '$cl_no'";
    $result5 = mysqli_query($conn, $sql5);
    $row5 = mysqli_num_rows($result5);
    if ($row5 == 0 || $mb_level == 2) {
      echo "";
    } else if ($row5 > 0 && $mb_level == 1) { ?>
      <a href="qna_upload.php?cl_no=<?= $cl_no ?>" title="글쓰기버튼" class="write_btn">
        <img src="./images/edit_white.svg" alt="질문하기">
      </a>
    <?php } ?>
  </div>


  <!-- history.back() 스크립트 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더스크립트 -->
  <script src="./script/header_m.js"></script>
  <!-- 페이지 링크 이동 -->
  <script src="./script/qna_page.js"></script>
</body>

</html>