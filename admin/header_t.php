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
      <img src="../guest/images/profile/<?= $profile['mb_photo'] ?? "" ?>" alt="프로필사진">
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
        <td><?php
        $sql = "SELECT COUNT(*) FROM gl_class WHERE cl_end >= CURDATE() and cl_start <= CURDATE() and mb_no = '$mb_no';";
        $count_result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_array($count_result);
        $cl_count = $count[0];
        ?> <?= $cl_count ?> 개</td>
        <td><a href="student_class.php" title="전체클래스">관리</a></td>
      </tr>

      <tr>
        <th>신규게시글</th>
        <td> <?php
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
          <?= $qna_count ?> 건
        </td>
        <td><a href="notice_ad_list.php" title="공지사항">관리</a></td>
      </tr>

      <tr>
        <th>신규수강생</th>
        <td><?php
        $sql = "SELECT COUNT(DISTINCT mb_no) FROM gl_class_member WHERE cm_datetime > NOW() - INTERVAL 1 DAY AND cl_no IN(SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
        $count_result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_array($count_result);
        $new_student_count = $count[0];
        ?> <?= $new_student_count ?> 명</td>
        <td><a href="student_list.php" title="전체수강생">관리</a></td>
      </tr>

      <tr>
        <th>수강생</th>
        <td><?php
        $sql = "SELECT COUNT(DISTINCT mb_no) FROM gl_class_member WHERE cl_no IN(SELECT cl_no FROM gl_class WHERE mb_no = $mb_no);";
        $count_result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_array($count_result);
        $student_count = $count[0];
        ?> <?= $student_count ?> 명</td>
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