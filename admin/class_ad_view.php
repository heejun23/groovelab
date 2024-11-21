<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>그루브랩 : 회원수정</title>

  <link rel="stylesheet" href="./css/reset.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/class_ad_view.css" />

  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 제이쿼리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- 학생멤버 뷰js -->
  <script src="./script/member_view_s.js"></script>
</head>

<body>

  <?php include ('./php/dbconn.php');

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
  <?php
  $cl_no = $_GET['cl_no'];
  $sql = "SELECT * FROM gl_class WHERE cl_no = '$cl_no'";
  $class_result = mysqli_query($conn, $sql);
  $class = mysqli_fetch_array($class_result);

  ?>
  <p class="branch">홈 &#x003E; 클래스관리 &#x003E; 전체클래스 &#x003E; 클래스상세</p>
  <main>
    <section id="center">
      <h3 class="blind">클래스정보</h3>
      <!-- 프로필 -->
      <article id="profile">
        <h2>클래스정보</h2>
        <div class="class_flex">
          <div class="class_notice_qna">
            <div class="class_info">
              <div class="class_profile">
                <img src="./images/class/<?= $class['cl_thumbnail'] ?>" alt="강의썸네일">
              </div>
              <div class="class_txt">
                <h3><?= $class['cl_title'] ?></h3>
                <p><?= $class['cl_category'] ?></p>
                <p>크리에이터 : <?= $class['cl_teacher'] ?></p>
                <p>강의시간 : <?= $class['cl_time'] ?>분</p>
                <p>강의시작일 : <?= $class['cl_start'] ?></p>
                <p>강의종료일 : <?= $class['cl_end'] ?></p>
                <p>가격 : <?= number_format($class['cl_price']) ?>원</p>
              </div>
            </div> <!-- class info : flex -->
            <div class="class_cont">
              <h4>강의내용</h4>
              <p><?= $class['cl_desc'] ?></p>
              <?php
              // 수강생 수 계산
              $cl_no = $class['cl_no'];
              $sql2 = "SELECT COUNT(*) as mb_count
                                  FROM gl_class_member cm
                                  INNER JOIN gl_class c ON cm.cl_no = c.cl_no
                                  WHERE cm.cl_no = '$cl_no'";
              $result2 = mysqli_query($conn, $sql2);
              $count = mysqli_fetch_assoc($result2);

              //사진 나오게하기
              $sql3 = "SELECT m.mb_photo
                              FROM gl_member m
                              INNER JOIN gl_class_member cm ON m.mb_no = cm.mb_no
                              WHERE cm.cm_status = 1 AND cm.cl_no = '$cl_no'
                              ORDER BY cm.cm_randate DESC
                              LIMIT 5;";
              $result3 = mysqli_query($conn, $sql3);
              ?>
              <div class="mb_count">
                <p class="mb_num"><?= $count['mb_count'] ?>명 수강중</p>
                <?php
                while ($photo = mysqli_fetch_assoc($result3)) { ?>
                  <p class="mb_img"><img src="../guest/images/profile/<?= $photo['mb_photo'] ?>" alt="사진"></p>

                <?php } ?>
              </div>
            </div>
            <!-- notice 공지사항 -->
            <div class="class_notice">
              <h2>공지사항</h2>
              <a href="notice_ad_list.php"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>
              <table>
                <caption class="blind">공지사항</caption>
                <?php
                $cl_no = $class['cl_no'];
                $notice = "SELECT no_title, no_datetime, no_no FROM gl_notice WHERE cl_no ='$cl_no' ORDER BY no_no DESC LIMIT 3";
                $no_result = mysqli_query($conn, $notice);
                if (mysqli_num_rows($no_result) == 0) { ?>
                  <tr>
                    <td>
                      <div class='no_class'>
                        <img src='./images/out_of_stock.png' alt='게시글없음'>
                        <p>등록된 게시글이 없습니다.</p>
                      </div>
                    </td>
                  </tr>
                <?php } else { ?>
                  <?php while ($no = mysqli_fetch_array($no_result)) {
                    ?>
                    <tr>
                      <td>
                        <a href="notice_ad_upload.php?type=modify&no_no=<?= $no['no_no'] ?>"><?= $no['no_title'] ?></a>
                        <span><?= substr($no['no_datetime'], 0, 10) ?></span>
                      </td>
                    </tr>
                  <?php }
                } ?>
              </table>
            </div>
            <!-- qna -->
            <div class="class_qna">
              <h2>QNA</h2>
              <a href="qna_ad_list.php"><img src="./images/plus_white.svg" alt="더보기버튼" class="plus"></a>
              <table>
                <caption class="blind">QNA</caption>
                <?php
                $cl_no = $class['cl_no'];
                $qna = "SELECT qna_title, qna_datetime, qna_no FROM gl_qna where cl_no='$cl_no' AND qna_parent_no IS NULL ORDER BY qna_no DESC LIMIT 3";
                $qq_result = mysqli_query($conn, $qna);
                if (mysqli_num_rows($qq_result) == 0) { ?>
                  <tr>
                    <td>
                      <div class='no_class'>
                        <img src='./images/out_of_stock.png' alt='게시글없음'>
                        <p>등록된 게시글이 없습니다.</p>
                      </div>
                    </td>
                  </tr>
                <?php } else {
                  while ($qq = mysqli_fetch_array($qq_result)) {

                    $qna_no = $qq['qna_no'];
                    $qna_p = "select * from gl_qna where qna_parent_no = '$qna_no'";
                    $result_p = mysqli_query($conn, $qna_p);
                    $qp = mysqli_fetch_assoc($result_p);
                    if (!$qp) { ?>
                      <tr>
                        <td>
                          <a href="./qna_ad_upload.php?type=update&qna_no=<?= $qq['qna_no'] ?>"><?= $qq['qna_title'] ?></a>
                          <span><?= substr($qq['qna_datetime'], 0, 10) ?></span>
                        </td>
                      </tr>
                    <?php } else { ?>
                      <tr>
                        <td>
                          <a href="./qna_ad_upload.php?type=modify&qna_no=<?= $qq['qna_no'] ?>"><?= $qq['qna_title'] ?></a>
                          <span><?= substr($qq['qna_datetime'], 0, 10) ?></span>
                        </td>
                      </tr>
                    <?php }
                  }
                } ?>
              </table>
            </div>
          </div> <!-- 강의정보 / 공지사항 / qna-->

          <!-- class목차 -->
          <div class="class_list">
            <h2>목차</h2>
            <ul>
              <?php
              $cl_no = $class['cl_no'];
              $sql = "SELECT * from gl_class_chapter where cl_no ='$cl_no' order by cc_chapter_no asc";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)):
                ?>
                <li>
                  <div class="class_chapter_no"><?= $row['cc_chapter_no'] ?>강</div>
                  <div class="class_chapter_title"><?= $row['cc_title'] ?></div>
                </li>
              <?php endwhile ?>
            </ul>
          </div>
        </div>
      </article>
    </section>
  </main>
  <script src="./script/header.js"></script>
  <script>
    // 삭제할때 confirm 스크립트
    function delete_check() {
      if (confirm('정말로 삭제하시겠습니까?')) {
        return true;
      } else {
        return false;
      }
    };

    //메뉴 열어놓기
    $(document).ready(function () {
      $(".sub_menu").eq(1).show();
      $(".gnb > li > a").eq(1).addClass('active').find('.open').addClass('reverse');
      $(".gnb > li > a").eq(1).find('.first_icon').addClass('white')
    });
  </script>
</body>

</html>