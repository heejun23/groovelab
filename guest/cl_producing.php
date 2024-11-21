<?php include('./php/dbconn.php') ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>그루브랩 : 클래스 목록</title>
  <!-- 파비콘 -->
  <link rel="icon" href="./images/favicon.ico" type="images/x-icon">
  <!-- 초기화 -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- 목록서식 -->
  <link rel="stylesheet" href="./css/class_list.css">

  <!-- 제이쿼리 라이브러리 -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- 뒤로가기 -->
  <script src="./script/goback.js"></script>
  <!-- 헤더 -->
  <script src="./script/header_m.js"></script>
</head>

<body>
  <?php include('./header_m.php') ?>

  <nav id="head">
    <a href="#" title="뒤로가기" onclick="goBack()"><img src="./images/history_back_white.svg" alt="뒤로가기"></a>
    <p>클래스</p>
  </nav>
  <main>
    <!-- 상단내비 -->
    <nav id="h_box">
      <ul id="h_list">
        <li><a href="class_list.php" title="전체">전체</a></li>
        <li><a href="cl_vocal.php" title="보컬">보컬</a></li>
        <li><a href="cl_hiphop.php" title="힙합">힙합</a></li>
        <li><a href="cl_musical.php" title="뮤지컬/재즈/클래식">뮤지컬/재즈/클래식</a></li>
        <li><a href="cl_producing.php" title="프로듀싱" class="h_on">프로듀싱</a></li>
        <li><a href="cl_lyric.php" title="작사/작곡">작사/작곡</a></li>
        <li><a href="cl_engineering.php" title="음향관리/엔지니어링">음향관리/엔지니어링</a></li>
      </ul>
    </nav>

    <!-- 내용 들어갈 곳 -->
    <section id="class_info">
      <?php
      $page_size = 10;
      $page_list_size = 5;

      $no = $_GET['no'] ?? 0;

      $query = "SELECT cl_start FROM gl_class 
      WHERE cl_end > CURDATE()
      AND cl_start <= CURDATE()
      AND cl_category = '프로듀싱클래스'
      ORDER BY cl_start DESC LIMIT $no,1";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      $start_no = $row[0];


      $sql = "SELECT
cl_category,
cl_title,
cl_teacher,
cl_price,
cl_thumbnail,
cl_no
FROM gl_class
WHERE cl_end > CURDATE()
AND cl_start <= CURDATE()
AND cl_category = '프로듀싱클래스'
      AND cl_start <='$start_no'
ORDER BY cl_start DESC";
      $sql .= " limit $page_size";

      $result = mysqli_query($conn, $sql);
      // $class = mysqli_fetch_array($result);

      $sql = "SELECT count(*) FROM gl_class
      WHERE cl_end > CURDATE()
      AND cl_start <= CURDATE()
      AND cl_category = '프로듀싱클래스'";

      $result_count = mysqli_query($conn, $sql);
      $result_row = mysqli_fetch_row($result_count);
      $total_row = $result_row[0];
      //전체 레코드 갯수를 구한다.

      if ($total_row <= 0)
        $total_row = 0;
      $total_page = floor(($total_row - 1) / $page_size);

      $current_page = floor($no / $page_size);
      //현재 페이지는 게시글 카운트에서 page_size로 나눠주면 된다.



      // 내용이 비었다면
      if (mysqli_num_rows($result) == 0) { ?>
        <div class="no_info">
          <img src="./images/out_of_stock.png" alt="정보없음">
          <p>클래스를 준비중입니다.</p>
        </div>
        <?php } else {
        while ($class = mysqli_fetch_array($result)) {
          $cl_no = $class['cl_no']
        ?>
          <a href="class_view.php?cl_no=<?= $class['cl_no'] ?>" class="info">
            <div class="img_box"><img src="../admin/images/class/<?= $class['cl_thumbnail'] ?>" alt=""></div>
            <div class="t_box">
              <p><?= $class['cl_teacher'] ?> &#x00B7; <?= $class['cl_category'] ?></p>
              <h4><?= $class['cl_title'] ?></h4>
              <p><?= number_format($class['cl_price'], 0) ?>원</p>
            </div>
          </a>
      <?php }
      } ?>

    </section>

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
        echo "<a href=\"cl_producing.php?no=$prev_list\"><img src='./images/prev_admin.svg'></a>";
      }
      // 지금 사용자가 보고 있는 페이지가 page_list_size보다 클 경우 이전 페이지 리스트로 넘어가기. 

      for ($i = $start_page; $i <= $end_page; $i++) {
        $page = $i * $page_size;
        $page_num = $i + 1; //0부터 시작하니 1을 더해준다.

        if ($no != $page) {
          echo "<a href=\"cl_producing.php?no=$page\">" . $page_num . "</a>";
        } else {
          echo "<span class='current_page'>" . $page_num . "</span>";
        }
      }

      if ($total_page > $end_page) {
        $next_list = ($end_page + 1) * $page_size;
        echo "<a href=\"cl_producing.php?no=$next_list\"><img src='./images/next_admin.svg'></a>";
      }
      //total_page가 end_page보다 더 크면 다음페이지 리스트를 보게 한다.
      ?>
    </div>
    <?php include('./bottom_gnb.php') ?>
  </main>
</body>

</html>